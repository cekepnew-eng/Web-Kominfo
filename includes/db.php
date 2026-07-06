<?php
// Database helper for admin dashboard. Edit credentials as needed.
$previousReportMode = mysqli_report(MYSQLI_REPORT_OFF);
if (!function_exists('get_env_var')) {
    function get_env_var(string $key, string $default = ''): string {
        $val = getenv($key);
        if ($val !== false && $val !== '') return $val;
        if (isset($_ENV[$key]) && $_ENV[$key] !== '') return $_ENV[$key];
        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') return $_SERVER[$key];
        return $default;
    }
}

$DB_HOST = get_env_var('MYSQLHOST', get_env_var('DB_HOST', '127.0.0.1'));
$DB_PORT = get_env_var('MYSQLPORT', get_env_var('DB_PORT', '3306'));
$DB_USER = get_env_var('MYSQLUSER', get_env_var('DB_USER', 'root'));
$DB_PASS = get_env_var('MYSQLPASSWORD', get_env_var('DB_PASS', ''));
$DB_NAME = get_env_var('MYSQLDATABASE', get_env_var('DB_NAME', 'kominfov2'));

// Fallback to MYSQL_URL if available (Railway specific)
$mysql_url = get_env_var('MYSQL_URL', get_env_var('DATABASE_URL'));
if ($mysql_url !== '') {
    $parsed = parse_url($mysql_url);
    if ($parsed !== false) {
        $DB_HOST = $parsed['host'] ?? $DB_HOST;
        $DB_PORT = $parsed['port'] ?? $DB_PORT;
        $DB_USER = $parsed['user'] ?? $DB_USER;
        $DB_PASS = $parsed['pass'] ?? $DB_PASS;
        if (!empty($parsed['path'])) {
            $DB_NAME = ltrim($parsed['path'], '/');
        }
    }
}

function db_get_conn(): ?mysqli
{
    global $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS, $DB_NAME;
    $m = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, (int)$DB_PORT);
    if ($m->connect_errno) {
        return null;
    }
    $m->set_charset('utf8mb4');
    return $m;
}
