<?php
declare(strict_types=1);

if (!function_exists('esc')) {
    function esc($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

function app_cache_path(): string
{
    $dir = __DIR__ . '/../uploads/cache';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    return $dir;
}

function app_cache_remember(string $key, int $ttlSeconds, callable $resolver)
{
    $path = app_cache_path() . '/' . md5($key) . '.json';
    if (is_file($path) && (time() - filemtime($path) < $ttlSeconds)) {
        $raw = file_get_contents($path);
        if ($raw !== false) {
            $decoded = json_decode($raw, true);
            if ($decoded !== null) {
                return $decoded;
            }
        }
    }

    $result = $resolver();
    file_put_contents($path, json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $result;
}

function http_get_simple(string $url, int $timeout = 12): ?string
{
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => $timeout,
            'header' => implode("\r\n", [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0 Safari/537.36',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: id-ID,id;q=0.9,en;q=0.8',
            ]),
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    $content = @file_get_contents($url, false, $context);
    return $content === false ? null : $content;
}

function clean_text(string $value): string
{
    $decoded = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    $decoded = strip_tags($decoded);
    $decoded = preg_replace('/\s+/u', ' ', $decoded) ?? $decoded;
    return trim($decoded);
}

function absolute_url(string $baseUrl, string $pathOrUrl): string
{
    $candidate = trim($pathOrUrl);
    if ($candidate === '') {
        return $baseUrl;
    }

    if (preg_match('/^https?:\/\//i', $candidate)) {
        return $candidate;
    }

    $parts = parse_url($baseUrl);
    if ($parts === false || empty($parts['scheme']) || empty($parts['host'])) {
        return $candidate;
    }

    $prefix = $parts['scheme'] . '://' . $parts['host'];
    if ($candidate[0] === '/') {
        return $prefix . $candidate;
    }

    return $prefix . '/' . $candidate;
}

function parse_indonesian_datetime(string $value): ?int
{
    $text = mb_strtolower(trim($value), 'UTF-8');
    if ($text === '') {
        return null;
    }

    $text = preg_replace('/\b(senin|selasa|rabu|kamis|jumat|jum\'at|sabtu|minggu)\b/u', '', $text) ?? $text;
    $text = preg_replace('/\b(wib|wita|wit)\b/u', '', $text) ?? $text;
    $text = str_replace(',', ' ', $text);

    $months = [
        'januari' => 'january',
        'februari' => 'february',
        'maret' => 'march',
        'april' => 'april',
        'mei' => 'may',
        'juni' => 'june',
        'juli' => 'july',
        'agustus' => 'august',
        'september' => 'september',
        'oktober' => 'october',
        'november' => 'november',
        'desember' => 'december',
    ];

    $normalized = strtr($text, $months);
    $normalized = preg_replace('/\s+/u', ' ', trim($normalized)) ?? trim($normalized);
    $timestamp = strtotime($normalized);

    return $timestamp === false ? null : $timestamp;
}

function format_indonesian_date(int $day, int $month, int $year): string
{
    $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $labelMonth = $monthNames[$month] ?? (string) $month;
    return sprintf('%02d %s %04d', $day, $labelMonth, $year);
}

function get_article_meta(string $url, int $ttlSeconds = 21600): array
{
    $cacheKey = 'article-meta-' . md5($url);

    return app_cache_remember($cacheKey, $ttlSeconds, static function () use ($url) {
        $default = ['image' => '', 'excerpt' => ''];
        $html = http_get_simple($url, 15);
        if ($html === null) {
            return $default;
        }

        $image = '';
        $excerpt = '';

        if (preg_match('/property="og:image"\s+content="([^"]+)"/i', $html, $imgMatch)) {
            $image = trim($imgMatch[1]);
        } elseif (preg_match('/name="twitter:image"\s+content="([^"]+)"/i', $html, $imgAltMatch)) {
            $image = trim($imgAltMatch[1]);
        }

        if (preg_match('/property="og:description"\s+content="([^"]+)"/i', $html, $descMatch)) {
            $excerpt = clean_text($descMatch[1]);
        } elseif (preg_match('/name="description"\s+content="([^"]+)"/i', $html, $descAltMatch)) {
            $excerpt = clean_text($descAltMatch[1]);
        }

        return [
            'image' => $image,
            'excerpt' => $excerpt,
        ];
    });
}

function get_kotabogor_news(int $limit = 16): array
{
    $fallback = [
        [
            'title' => 'Berita terbaru Pemerintah Kota Bogor',
            'url' => 'https://kotabogor.go.id/berita',
            'source' => 'kotabogor.go.id',
            'published' => 'Update terbaru',
            'published_iso' => date('c'),
            'excerpt' => 'Lihat publikasi resmi terbaru dari Pemerintah Kota Bogor.',
            'image' => '',
        ],
    ];

    return app_cache_remember('kotabogor-news', 300, static function () use ($limit, $fallback) {
        $html = http_get_simple('https://kotabogor.go.id/berita', 20);
        if ($html === null) {
            return $fallback;
        }

        $pattern = '/<img\s+src="([^"]+)"[^>]*>\s*<a\s+href="([^"]*\/berita-detail\/\d+)"[^>]*>.*?<div class="blog-one__date">.*?<p>\s*(\d{1,2})-\s*(\d{1,2})\s*<br>\s*<span>(\d{4})<\/span>.*?<h3[^>]*>\s*<a[^>]+href="([^"]*\/berita-detail\/[^"]+)"[^>]*>(.*?)<\/a>/is';

        preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
        if (empty($matches)) {
            return $fallback;
        }

        $news = [];
        $seen = [];

        foreach ($matches as $match) {
            $image = trim($match[1] ?? '');
            $readUrl = absolute_url('https://kotabogor.go.id', (string) ($match[2] ?? ''));
            $titleUrl = absolute_url('https://kotabogor.go.id', (string) ($match[6] ?? ''));
            $title = clean_text((string) ($match[7] ?? ''));
            $url = $titleUrl !== '' ? $titleUrl : $readUrl;

            if ($title === '' || $url === '' || isset($seen[$url])) {
                continue;
            }

            $seen[$url] = true;

            $day = (int) ($match[3] ?? 0);
            $month = (int) ($match[4] ?? 0);
            $year = (int) ($match[5] ?? 0);
            $ts = ($day > 0 && $month > 0 && $year > 0) ? strtotime(sprintf('%04d-%02d-%02d 07:00:00', $year, $month, $day)) : time();

            $news[] = [
                'title' => $title,
                'url' => $url,
                'source' => 'kotabogor.go.id',
                'published' => format_indonesian_date(max(1, $day), max(1, $month), max(1970, $year)),
                'published_iso' => date('c', $ts),
                'excerpt' => 'Berita resmi terbaru dari Pemerintah Kota Bogor.',
                'image' => $image,
            ];

            if (count($news) >= $limit) {
                break;
            }
        }

        foreach ($news as $index => $item) {
            $meta = get_article_meta((string) $item['url']);
            if ($news[$index]['image'] === '' && !empty($meta['image'])) {
                $news[$index]['image'] = $meta['image'];
            }
            if (!empty($meta['excerpt'])) {
                $news[$index]['excerpt'] = $meta['excerpt'];
            }
        }

        return empty($news) ? $fallback : $news;
    });
}

function get_realtime_news_feed(int $limit = 60): array
{
    // Coba ambil dari Database (Admin Panel) jika ada
    if (function_exists('db_get_conn')) {
        $conn = db_get_conn();
        if ($conn !== null) {
            try {
                $safeLimit = (int) $limit;
                $sql = "SELECT id, title, url, source, published, published_iso, excerpt, image, created_at FROM news_articles ORDER BY id DESC LIMIT $safeLimit";
                $res = $conn->query($sql);
                if ($res && $res->num_rows > 0) {
                    $news = [];
                    while ($row = $res->fetch_assoc()) {
                        $news[] = [
                            'title' => clean_text($row['title']),
                            'url' => $row['url'],
                            'source' => $row['source'],
                            'published' => $row['published'],
                            'published_iso' => $row['published_iso'] ?? date('c', strtotime($row['created_at'])),
                            'excerpt' => clean_text($row['excerpt']),
                            'image' => $row['image']
                        ];
                    }
                    $conn->close();
                    return $news;
                }
                $conn->close();
            } catch (\Exception $e) {
                // Ignore DB error and fallback to scraping
            }
        }
    }

    // Fallback: Scraping (Cache)
    return app_cache_remember('realtime-news-feed-' . $limit, 120, static function () use ($limit) {
        $komdigiPortion = max(8, (int) ceil($limit * 0.55));
        $detikPortion = max(8, (int) ceil($limit * 0.45));

        $items = array_merge(
            get_komdigi_news($komdigiPortion),
            get_detik_bogor_news($detikPortion)
        );

        foreach ($items as $idx => $item) {
            $publishedIso = (string) ($item['published_iso'] ?? '');
            $timestamp = $publishedIso !== '' ? strtotime($publishedIso) : false;

            if ($timestamp === false) {
                $timestamp = parse_indonesian_datetime((string) ($item['published'] ?? ''));
            }

            $items[$idx]['timestamp'] = $timestamp ?: (time() - $idx);
            $items[$idx]['published_iso'] = $timestamp ? date('c', $timestamp) : date('c');
            $items[$idx]['title'] = clean_text((string) ($item['title'] ?? 'Berita terbaru'));
            $items[$idx]['source'] = clean_text((string) ($item['source'] ?? 'Sumber resmi'));
            $items[$idx]['excerpt'] = clean_text((string) ($item['excerpt'] ?? ''));
            $items[$idx]['url'] = trim((string) ($item['url'] ?? ''));
            $items[$idx]['image'] = trim((string) ($item['image'] ?? ''));
        }

        $items = array_values(array_filter($items, static function (array $item): bool {
            return $item['title'] !== '' && $item['url'] !== '';
        }));

        usort($items, static function (array $a, array $b): int {
            return (int) ($b['timestamp'] ?? 0) <=> (int) ($a['timestamp'] ?? 0);
        });

        return array_slice($items, 0, $limit);
    });
}

function count_cctv_streams(): int
{
    if (function_exists('db_get_conn')) {
        $m = db_get_conn();
        if ($m) {
            $sql = 'SELECT COUNT(id) as total FROM cctv_streams WHERE is_active=1';
            if ($res = $m->query($sql)) {
                $r = $res->fetch_assoc();
                $m->close();
                return (int)$r['total'];
            }
        }
    }
    return 6; // Fallback estimate
}

function get_bogor_cctv_streams(int $limit = 12, int $offset = 0): array
{
    $fallback = [
        ['id' => '76', 'name' => 'Simpang Kapten Muslihat-Djuanda', 'stream' => 'https://restreamer2.kotabogor.go.id/memfs/3ec6eaf2-4da1-4adb-8c15-0251e69121d6.m3u8', 'detail' => 'https://bsw.kotabogor.go.id/cctv/76/detail'],
        ['id' => '79', 'name' => 'Simpang Tugu Kujang', 'stream' => 'https://restreamer2.kotabogor.go.id/memfs/5a5cf878-9d9b-4400-a73a-27a5b24a6ec4.m3u8', 'detail' => 'https://bsw.kotabogor.go.id/cctv/79/detail'],
        ['id' => '82', 'name' => 'Depan Alun Alun', 'stream' => 'https://restreamer2.kotabogor.go.id/memfs/c07c1926-288c-46e4-a19c-9f51022edc5d.m3u8', 'detail' => 'https://bsw.kotabogor.go.id/cctv/82/detail'],
        ['id' => '83', 'name' => 'Pasar Bogor', 'stream' => 'https://restreamer2.kotabogor.go.id/memfs/b43066d4-b1e4-4e90-8e17-86c15a9a944e.m3u8', 'detail' => 'https://bsw.kotabogor.go.id/cctv/83/detail'],
        ['id' => '85', 'name' => 'Juanda', 'stream' => 'https://restreamer2.kotabogor.go.id/memfs/62cded1f-90d0-4af6-b330-dc40af5fdd67.m3u8', 'detail' => 'https://bsw.kotabogor.go.id/cctv/85/detail'],
        ['id' => '86', 'name' => 'Seketeng Surken', 'stream' => 'https://restreamer2.kotabogor.go.id/memfs/3d51d3a1-0d90-4230-956c-60dea3c11ac3.m3u8', 'detail' => 'https://bsw.kotabogor.go.id/cctv/86/detail'],
    ];

    // If DB is available and has cctv_streams, prefer that (admin-managed)
    if (function_exists('db_get_conn')) {
        $m = db_get_conn();
        if ($m) {
            $safeLimit = (int) $limit;
            $safeOffset = (int) $offset;
            $rows = [];
            $sql = "SELECT external_id AS id, name, stream_url AS stream, detail_url AS detail FROM cctv_streams WHERE is_active=1 ORDER BY id ASC LIMIT $safeLimit OFFSET $safeOffset";
            if ($res = $m->query($sql)) {
                while ($r = $res->fetch_assoc()) {
                    $rows[] = $r;
                }
                $res->free();
            }
            $m->close();
            if (!empty($rows)) {
                return $rows;
            }
        }
    }

    return app_cache_remember('bogor-cctv-streams', 900, static function () use ($limit, $fallback) {
        $listing = http_get_simple('https://bsw.kotabogor.go.id/cctv', 15);
        if ($listing === null) {
            return array_slice($fallback, 0, $limit);
        }

        preg_match_all('/<a[^>]+href="https:\/\/bsw\.kotabogor\.go\.id\/cctv\/(\d+)\/detail"[^>]*>(.*?)<\/a>/is', $listing, $matches, PREG_SET_ORDER);
        if (empty($matches)) {
            return array_slice($fallback, 0, $limit);
        }

        $unique = [];
        $items = [];
        foreach ($matches as $match) {
            $id = $match[1];
            if (isset($unique[$id])) {
                continue;
            }
            $unique[$id] = true;

            $rawName = trim(strip_tags($match[2]));
            $name = preg_replace('/^CCTV\s*[-:]*\s*/i', '', $rawName);
            $name = $name !== '' ? $name : ('CCTV ' . $id);

            $detailUrl = 'https://bsw.kotabogor.go.id/cctv/' . $id . '/detail';
            $detailHtml = http_get_simple($detailUrl, 12);
            if ($detailHtml === null) {
                continue;
            }

            if (!preg_match('/https:\/\/restreamer2\.kotabogor\.go\.id\/memfs\/[^"\'\s<>]+\.m3u8/i', $detailHtml, $streamMatch)) {
                continue;
            }

            $items[] = [
                'id' => $id,
                'name' => $name,
                'stream' => $streamMatch[0],
                'detail' => $detailUrl,
            ];

            if (count($items) >= $limit) {
                break;
            }
        }

        if (empty($items)) {
            return array_slice($fallback, 0, $limit);
        }

        return $items;
    });
}

function get_komdigi_news(int $limit = 12): array
{
    $fallback = [
        [
            'title' => 'Berita Kementerian Komunikasi dan Digital',
            'url' => 'https://www.komdigi.go.id/berita',
            'source' => 'komdigi.go.id',
            'published' => 'Update terbaru',
            'excerpt' => 'Informasi terbaru dari situs resmi Kementerian Komunikasi dan Digital.',
            'image' => '',
        ],
    ];

    return app_cache_remember('komdigi-news', 600, static function () use ($limit, $fallback) {
        $mirror = http_get_simple('https://r.jina.ai/https://www.komdigi.go.id/berita', 15);
        if ($mirror === null) {
            return $fallback;
        }

        preg_match_all('/!\[Image [^\]]*\]\(([^)]+)\).*?##\s*\[([^\]]+)\]\(([^)]+)\)/is', $mirror, $matches, PREG_SET_ORDER);
        
        $news = [];
        foreach ($matches as $idx => $m) {
            $news[] = [
                'title' => clean_text($m[2]),
                'url' => $m[3],
                'source' => 'komdigi.go.id',
                'published' => date('d M Y'),
                'published_iso' => date('c'),
                'excerpt' => 'Baca selengkapnya di situs resmi Kementerian Komdigi.',
                'image' => $m[1],
                'timestamp' => time() - $idx,
            ];
            if (count($news) >= $limit) break;
        }

        return empty($news) ? $fallback : $news;
    });
}

function get_detik_bogor_news(int $limit = 12): array
{
    $fallback = [
        [
            'title' => 'Berita Bogor terkini di Detik',
            'url' => 'https://www.detik.com/tag/bogor',
            'source' => 'detik.com',
            'published' => 'Update terbaru',
            'excerpt' => 'Informasi terbaru terkait Bogor dari kanal berita detik.com.',
            'image' => '',
        ],
    ];

    return app_cache_remember('detik-bogor-news', 600, static function () use ($limit, $fallback) {
        $mirror = http_get_simple('https://r.jina.ai/http://www.detik.com/tag/bogor', 15);
        if ($mirror === null) {
            return $fallback;
        }

        $lines = preg_split('/\R/', $mirror) ?: [];
        $news = [];
        $seen = [];

        foreach ($lines as $line) {
            if (!preg_match('/\[(.*?)\]\((https?:\/\/[^\)]+)\)/', $line, $m)) {
                continue;
            }

            $title = trim($m[1]);
            $url = trim($m[2]);

            if ($title === '' || $url === '') {
                continue;
            }
            if (strpos($url, 'detik.com') === false) {
                continue;
            }
            if (strpos($url, '/tag/') !== false || strpos($url, '/foto/') !== false || strpos($url, '/live/') !== false) {
                continue;
            }
            if (!preg_match('/\/d-\d+\//', $url)) {
                continue;
            }
            if (isset($seen[$url])) {
                continue;
            }

            $seen[$url] = true;

            $published = 'Update terbaru';
            if (preg_match('/\b(\d{1,2}\s+\w+\s+\d{4}\s+\d{1,2}:\d{2}\s+WIB)\b/u', $line, $timeMatch)) {
                $published = $timeMatch[1];
            }

            $news[] = [
                'title' => preg_replace('/\s+/', ' ', $title),
                'url' => $url,
                'source' => 'detik.com',
                'published' => $published,
                'published_iso' => '',
                'excerpt' => 'Ringkasan berita terkait Bogor dari kanal detik.com.',
                'image' => '',
            ];

            if (count($news) >= $limit) {
                break;
            }
        }

        if (empty($news)) {
            $html = http_get_simple('https://www.detik.com/tag/bogor', 15);
            if ($html !== null) {
                preg_match_all('/<article\b.*?<\/article>/is', $html, $articleBlocks);
                foreach (($articleBlocks[0] ?? []) as $block) {
                    if (!preg_match('/<a\s+href="(https:\/\/[^"]*\/d-\d+\/[^"]+)"/i', $block, $urlMatch)) {
                        continue;
                    }

                    $url = trim((string) ($urlMatch[1] ?? ''));
                    $title = '';
                    if (preg_match('/alt="([^"]+)"/i', $block, $altMatch)) {
                        $title = clean_text((string) ($altMatch[1] ?? ''));
                    }
                    if ($title === '' && preg_match('/title="([^"]+)"/i', $block, $titleMatch)) {
                        $title = clean_text((string) ($titleMatch[1] ?? ''));
                    }

                    $published = 'Update terbaru';
                    if (preg_match('/<span\s+class="date">\s*<span\s+class="category">[^<]*<\/span>\s*([^<]+)</i', $block, $dateMatch)) {
                        $published = clean_text((string) ($dateMatch[1] ?? ''));
                    }

                    $image = '';
                    if (preg_match('/data-src="([^"]+)"/i', $block, $imgDataMatch)) {
                        $image = trim((string) ($imgDataMatch[1] ?? ''));
                    } elseif (preg_match('/<img[^>]+src="([^"]+)"/i', $block, $imgMatch)) {
                        $image = trim((string) ($imgMatch[1] ?? ''));
                    }

                    if ($url === '' || $title === '') {
                        continue;
                    }
                    if (isset($seen[$url])) {
                        continue;
                    }
                    if (mb_strlen($title, 'UTF-8') < 20) {
                        continue;
                    }

                    $seen[$url] = true;
                    $news[] = [
                        'title' => $title,
                        'url' => $url,
                        'source' => 'detik.com',
                        'published' => $published,
                        'published_iso' => '',
                        'excerpt' => 'Ringkasan berita terkait Bogor dari kanal detik.com.',
                        'image' => $image,
                    ];

                    if (count($news) >= $limit) {
                        break;
                    }
                }
            }
        }

        if (empty($news)) {
            return $fallback;
        }

        foreach ($news as $index => $item) {
            // Resolve article metadata once and store it in cache for faster subsequent loads.
            $meta = get_detik_article_meta((string) $item['url']);
            if (!empty($meta['image'])) {
                $news[$index]['image'] = $meta['image'];
            }
            if (!empty($meta['excerpt'])) {
                $news[$index]['excerpt'] = $meta['excerpt'];
            }

            $parsedTs = parse_indonesian_datetime((string) ($item['published'] ?? ''));
            if ($parsedTs !== null) {
                $news[$index]['published_iso'] = date('c', $parsedTs);
            }
        }

        return $news;
    });
}

function get_detik_article_meta(string $url): array
{
    return get_article_meta($url, 21600);
}
