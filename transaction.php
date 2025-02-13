<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $received_amount = $_POST['received_amount'] ?? 0;
    $total_amount = $_POST['total_amount'] ?? 0;

    
    $log_file = '/home/eksan/logs/log.txt';
    $timestamp = date("Y-m-d H:i:s");
    file_put_contents($log_file, "[$timestamp] Uang masuk: Rp. $received_amount, Total akumulasi: Rp. $total_amount\n", FILE_APPEND);

    echo json_encode(["message" => "Data transaksi berhasil diterima!"]);
} else {
    echo json_encode(["message" => "Hanya menerima POST request"]);
}
?>
