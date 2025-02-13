<?php
// Membaca data dari log transaksi yang disimpan
$log_file = '/home/eksan/logs/log.txt';
$log_content = file_get_contents($log_file);

// Menangani POST request jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $received_amount = $_POST['received_amount'] ?? 0;
    $total_amount = $_POST['total_amount'] ?? 0;

    // Menyimpan data transaksi ke dalam file log
    $timestamp = date("Y-m-d H:i:s");
    file_put_contents($log_file, "[$timestamp] Uang masuk: Rp. $received_amount, Total akumulasi: Rp. $total_amount\n", FILE_APPEND);

    // Set response header agar JavaScript bisa menangani response JSON
    header('Content-Type: application/json');
    echo json_encode(["message" => "Data transaksi berhasil diterima!"]);
    exit();
}
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
    <form method="POST" action="">
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
            fetch('log.txt')  // Pastikan ini mengarah ke file log yang benar
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
