<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $received_amount = $_POST['received_amount'] ?? 0;
    $total_amount = $_POST['total_amount'] ?? 0;

    $_SESSION['received_amount'] = $received_amount;
    $_SESSION['total_amount'] = $total_amount;

    echo json_encode([
        'status' => 'success',
        'message' => 'Data transaksi diterima',
        'received_amount' => $received_amount,
        'total_amount' => $total_amount
    ]);
} else {
    $received_amount = $_SESSION['received_amount'] ?? 0;
    $total_amount = $_SESSION['total_amount'] ?? 0;

    echo json_encode([
        'status' => 'success',
        'received_amount' => $received_amount,
        'total_amount' => $total_amount
    ]);
}
?>
