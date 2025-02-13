<?php
session_start();

$log_file = '/var/www/html/logs/log.txt';
$total_amount = 0;
$log_entries = [];

if (file_exists($log_file)) {
    // Membaca file log
    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, 'Akumulasi transaksi:') !== false) {
            preg_match('/Rp\.(\d+)/', $line, $matches);
            if (isset($matches[1])) {
                $total_amount = (int) $matches[1];
            }
        }
        $log_entries[] = $line;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $received_amount = $_POST['received_amount'] ?? 0;
    $total_amount = $_POST['total_amount'] ?? 0;

    $_SESSION['received_amount'] = $received_amount;
    $_SESSION['total_amount'] = $total_amount;

    echo json_encode([
        'status' => 'success',
        'received_amount' => $received_amount,
        'total_amount' => $total_amount
    ]);
    exit;
}

$received_amount = $_SESSION['received_amount'] ?? 0;
$total_amount = $total_amount;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Transaction Data</title>
</head>
<body>
    <h1>Data Transaksi Bill Acceptor</h1>

    <h2>Transaksi Terkini (Real-Time):</h2>
    <div id="transaction_data"></div>
    <h3>Log Transaksi Terakhir:</h3>
    <ul id="logs"></ul>

    <script>
    function updateTransactionData() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                if (data.status === 'success') {
                    // Menampilkan data transaksi
                    document.getElementById('transaction_data').innerHTML = 
                        `Uang Masuk: Rp. ${data.received_amount} <br>
                         Total Akumulasi: Rp. ${data.total_amount} <br>`;

                    let logs = data.logs.map(log => `<li>${log}</li>`).join('');
                    document.getElementById('logs').innerHTML = logs;
                } else {
                    document.getElementById('transaction_data').innerHTML = 'Error retrieving data';
                }
            }
        };
        xhr.send();
    }
    setInterval(updateTransactionData, 50);
    </script>
</body>
</html>
