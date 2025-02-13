<?php
// Membaca data dari log transaksi yang disimpan
$log_file = '/home/eksan/logs/log.txt';
$log_content = file_get_contents($log_file);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <!-- Mengatur agar halaman refresh setiap 5 detik -->
    <meta http-equiv="refresh" content="5">
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

    <h2>Transaksi Terkini (Real-Time):</h2>
    <div id="transaction_data"></div>

    <script>
        // Fungsi untuk mengambil data transaksi dari file
        function updateTransactionData() {
            fetch('/transaction_log.txt')
            .then(response => response.text())
            .then(data => {
                document.getElementById('transaction_data').innerText = data;
            });
        }

        // Memanggil updateTransactionData setiap 5 detik untuk memuat data terbaru
        setInterval(updateTransactionData, 5000);
    </script>
</body>
</html>
