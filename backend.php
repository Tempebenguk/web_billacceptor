<?php
session_start();

$log_file = '/var/www/html/logs/log.txt';
$log_entries = [];

if (!file_exists($log_file)) {
    die(json_encode(['status' => 'error', 'message' => '⚠️ File log tidak ditemukan!']));
}

if (!is_readable($log_file)) {
    die(json_encode(['status' => 'error', 'message' => '⚠️ File log tidak dapat dibaca! Periksa izin akses.']));
}

$lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($lines === false) {
    die(json_encode(['status' => 'error', 'message' => '⚠️ Gagal membaca file log!']));
}

foreach ($lines as $line) {
    $log_entries[] = htmlspecialchars($line);
}

echo json_encode([
    'status' => 'success',
    'logs' => array_slice($log_entries, -10)
]);
exit;
?>