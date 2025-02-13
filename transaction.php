<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $received_amount = $_POST['received_amount'] ?? 0;
    $total_amount = $_POST['total_amount'] ?? 0;

    echo "Uang masuk: Rp. $received_amount<br>";
    echo "Total Akumulasi: Rp. $total_amount<br>";
} else {
    echo "Hanya menerima POST request";
}
?>
