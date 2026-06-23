<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/services.php';

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$perPage = isset($_GET['per_page']) ? (int) $_GET['per_page'] : 9;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$query = trim((string) ($_GET['q'] ?? ''));
$force = isset($_GET['force']) && (string) $_GET['force'] === '1';

$perPage = max(3, min(24, $perPage));
$page = max(1, $page);

$fetchLimit = 96;
if ($force) {
    $cacheFile = app_cache_path() . '/' . md5('realtime-news-feed-' . $fetchLimit) . '.json';
    if (is_file($cacheFile)) {
        @unlink($cacheFile);
    }
}

$items = get_realtime_news_feed($fetchLimit);
// Attempt to append manual articles from local DB (non-destructive)
// If DB is not configured or unavailable, this step is skipped.
@include_once __DIR__ . '/../includes/db.php';
$dbConn = function_exists('db_get_conn') ? db_get_conn() : null;
if ($dbConn !== null) {
    // include manual_articles
    $q1 = 'SELECT id,title,excerpt,image,url,published FROM manual_articles WHERE is_published=1 ORDER BY published DESC LIMIT 200';
    if ($res = $dbConn->query($q1)) {
        while ($row = $res->fetch_assoc()) {
            $items[] = [
                'title' => $row['title'],
                'url' => $row['url'] ?: ('/index.php?manual_id=' . $row['id']),
                'source' => 'local',
                'published' => date('d M Y H:i', strtotime($row['published'])),
                'published_iso' => date('c', strtotime($row['published'])),
                'excerpt' => $row['excerpt'],
                'image' => $row['image'],
            ];
        }
        $res->free();
    }
    // include news table entries
    $q2 = 'SELECT id,title,excerpt,thumbnail AS image,CONCAT("/index.php?news_id=",id) AS url,published_at AS published FROM news WHERE is_published=1 ORDER BY published_at DESC LIMIT 200';
    if ($res2 = $dbConn->query($q2)) {
        while ($row = $res2->fetch_assoc()) {
            $items[] = [
                'title' => $row['title'],
                'url' => $row['url'],
                'source' => 'db-news',
                'published' => date('d M Y H:i', strtotime($row['published'])),
                'published_iso' => date('c', strtotime($row['published'])),
                'excerpt' => $row['excerpt'],
                'image' => $row['image'],
            ];
        }
        $res2->free();
    }
    $dbConn->close();
    // sort items by published date (newest first) when possible
    usort($items, static function ($a, $b) {
        $ta = 0;
        $tb = 0;
        if (!empty($a['published_iso'])) { $ta = strtotime($a['published_iso']); }
        elseif (!empty($a['published'])) { $ta = strtotime($a['published']); }
        if (!empty($b['published_iso'])) { $tb = strtotime($b['published_iso']); }
        elseif (!empty($b['published'])) { $tb = strtotime($b['published']); }
        return $tb <=> $ta;
    });
}

if ($query !== '') {
    $keyword = mb_strtolower($query, 'UTF-8');
    $items = array_values(array_filter($items, static function (array $item) use ($keyword): bool {
        $haystack = mb_strtolower(
            trim((string) ($item['title'] ?? '')) . ' ' .
            trim((string) ($item['excerpt'] ?? '')) . ' ' .
            trim((string) ($item['source'] ?? '')),
            'UTF-8'
        );

        return $haystack !== '' && mb_strpos($haystack, $keyword) !== false;
    }));
}

$totalItems = count($items);
$totalPages = max(1, (int) ceil($totalItems / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;
$pagedItems = array_slice($items, $offset, $perPage);

$response = [
    'success' => true,
    'meta' => [
        'page' => $page,
        'per_page' => $perPage,
        'total_items' => $totalItems,
        'total_pages' => $totalPages,
        'query' => $query,
        'updated_at' => date('c'),
        'refresh_interval_seconds' => 120,
        'sources' => [
            'https://kotabogor.go.id/berita',
            'https://www.detik.com/tag/bogor',
        ],
    ],
    'items' => array_map(static function (array $item): array {
        return [
            'title' => (string) ($item['title'] ?? ''),
            'url' => (string) ($item['url'] ?? ''),
            'source' => (string) ($item['source'] ?? ''),
            'published' => (string) ($item['published'] ?? 'Update terbaru'),
            'published_iso' => (string) ($item['published_iso'] ?? ''),
            'excerpt' => (string) ($item['excerpt'] ?? ''),
            'image' => (string) ($item['image'] ?? ''),
        ];
    }, $pagedItems),
];

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
