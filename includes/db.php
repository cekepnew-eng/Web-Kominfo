<?php
// Database helper for admin dashboard. Edit credentials as needed.
$previousReportMode = mysqli_report(MYSQLI_REPORT_OFF);
$DB_HOST = getenv('MYSQLHOST') ?: (getenv('DB_HOST') ?: '127.0.0.1');
$DB_PORT = getenv('MYSQLPORT') ?: (getenv('DB_PORT') ?: '3306');
$DB_USER = getenv('MYSQLUSER') ?: (getenv('DB_USER') ?: 'root');
$DB_PASS = getenv('MYSQLPASSWORD') ?: (getenv('DB_PASS') ?: '');
$DB_NAME = getenv('MYSQLDATABASE') ?: (getenv('DB_NAME') ?: 'kominfov2');

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
