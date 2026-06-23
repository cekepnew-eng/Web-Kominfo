<?php
// Database helper for admin dashboard. Edit credentials as needed.
$previousReportMode = mysqli_report(MYSQLI_REPORT_OFF);
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'kominfov2';

function db_get_conn(): ?mysqli
{
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
    $m = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($m->connect_errno) {
        return null;
    }
    $m->set_charset('utf8mb4');
    return $m;
}
