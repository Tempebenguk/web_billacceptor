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
    <meta http-equiv="refresh" content="1">
</head>
<body>
    <h1>Data Transaksi Bill Acceptor</h1>

    <h2>Riwayat Transaksi:</h2>
    <pre><?php echo $log_content; ?></pre>

    <h2>Transaksi Terkini (Real-Time):</h2>
    <div id="transaction_data"></div>

    <script>
        function updateTransactionData() {
            const timestamp = new Date().getTime();
            fetch('log-display.php?timestamp=' + timestamp)
            .then(response => response.text())
            .then(data => {
                document.getElementById('transaction_data').innerText = data;
            });
        }

        setInterval(updateTransactionData, 1000);
    </script>
</body>
</html>
