<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

$log_file = '/var/www/html/logs/log.txt';

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

$log_entries = array_slice($lines, -10);

$last_received = 0;
$total_amount = 0;

foreach (array_reverse($lines) as $line) {
    if (preg_match('/💰 Uang masuk: Rp\.(\d+)/', $line, $match)) {
        $last_received = (int) $match[1];
        break;
    }
}

foreach ($lines as $line) {
    if (preg_match('/🛑 Transaksi selesai! Total akhir: Rp\.(\d+)/', $line, $match)) {
        $total_amount = (int) $match[1];
    }
}

echo json_encode([
    'status' => 'success',
    'logs' => array_map('htmlspecialchars', $log_entries),
    'last_received' => $last_received,
    'total_amount' => $total_amount
]);
exit;
?>