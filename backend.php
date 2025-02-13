<?php
session_start();

$log_file = '/var/www/html/logs/log.txt';
$total_amount = 0;
$log_entries = [];

if (file_exists($log_file)) {
    // Membaca file log
    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Mencari baris yang mengandung 'Akumulasi transaksi:'
        if (strpos($line, 'Akumulasi transaksi:') !== false) {
            preg_match('/Rp\.(\d+)/', $line, $matches);
            if (isset($matches[1])) {
                $total_amount = (int) $matches[1];
            }
        }
        $log_entries[] = $line;
    }
}

echo json_encode([
    'status' => 'success',
    'received_amount' => $_SESSION['received_amount'] ?? 0,
    'total_amount' => $total_amount,
    'logs' => array_slice($log_entries, -10)
]);
exit;
?>
