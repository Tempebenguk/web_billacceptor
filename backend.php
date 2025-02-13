<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

$log_file = '/var/www/html/logs/log.txt';
$total_amount = 0;
$last_received = $_SESSION['received_amount'] ?? 0;
$log_entries = [];

if (file_exists($log_file)) {
    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '💰 Uang masuk:') !== false) {
            preg_match('/Rp\.(\d+)/', $line, $matches);
            if (isset($matches[1])) {
                $last_received = (int) $matches[1]; // Menyimpan uang masuk terakhir
                $_SESSION['received_amount'] = $last_received;
            }
        }
        if (strpos($line, 'Akumulasi transaksi:') !== false) {
            preg_match('/Rp\.(\d+)/', $line, $matches);
            if (isset($matches[1])) {
                $total_amount = (int) $matches[1]; // Mengambil total akumulasi
            }
        }
        $log_entries[] = $line;
    }
}

echo json_encode([
    'status' => 'success',
    'last_received' => $last_received, // Mengirim nilai uang masuk terakhir
    'total' => $total_amount,          // Mengirim nilai total akumulasi
    'logs' => array_slice($log_entries, -10) // Mengirim 10 log terakhir
]);
exit;
?>
