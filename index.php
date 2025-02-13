<?php
$log_file = '/home/eksan/logs/log.txt';
$log_content = file_get_contents($log_file);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
</head>
<body>
    <h1>Data Transaksi Bill Acceptor</h1>

    <h2>Riwayat Transaksi:</h2>
    <pre><?php echo $log_content; ?></pre>

    <h2>Form Input Transaksi (Untuk Testing)</h2>
    <form method="POST" action="transaction.php">
        <label for="received_amount">Jumlah Uang Masuk:</label><br>
        <input type="number" name="received_amount" required><br>
        <label for="total_amount">Total Akumulasi:</label><br>
        <input type="number" name="total_amount" required><br><br>
        <input type="submit" value="Kirim Transaksi">
    </form>

</body>
</html>
