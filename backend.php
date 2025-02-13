<?php
session_start();

$log_file = '/var/www/html/logs/log.txt';
$total_amount = 0;
$last_received = $_SESSION['received_amount'] ?? 0;
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
    if (strpos($line, '💰 Uang masuk:') !== false) {
        preg_match('/Rp\.(\d+)/', $line, $matches);
        if (isset($matches[1])) {
            $last_received = (int) $matches[1];
            $_SESSION['received_amount'] = $last_received;
        }
    }
    if (strpos($line, 'Akumulasi transaksi:') !== false) {
        preg_match('/Rp\.(\d+)/', $line, $matches);
        if (isset($matches[1])) {
            $total_amount = (int) $matches[1];
        }
    }
    $log_entries[] = htmlspecialchars($line);
}

echo json_encode([
    'status' => 'success',
    'last_received' => $last_received,
    'total' => $total_amount,
    'logs' => array_slice($log_entries, -10)
]);
exit;
?>