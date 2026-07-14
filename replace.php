<?php
$files = [
    'c:/laragon/www/kominfov2/user/kinara.php',
    'c:/laragon/www/kominfov2/includes/header.php',
    'c:/laragon/www/kominfov2/includes/footer.php',
    'c:/laragon/www/kominfov2/user/index.php'
];
foreach ($files as $f) {
    if (file_exists($f)) {
        $c = file_get_contents($f);
        $c = str_replace('wowoembege.php', 'kinara.php', $c);
        $c = str_replace('Wowoembege AI', 'Kinara AI', $c);
        $c = str_replace('Wowoembege', 'Kinara', $c);
        file_put_contents($f, $c);
    }
}
