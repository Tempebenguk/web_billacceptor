<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Cek apakah data diterima melalui POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari POST
    $received_amount = $_POST['received_amount'] ?? 0;
    $total_amount = $_POST['total_amount'] ?? 0;

    // Simpan data atau lakukan pengolahan sesuai kebutuhan
    // Misalnya, simpan data di file log atau database
    // Contoh menyimpan ke file log
    $log_file = '/var/www/html/logs/log.txt';
    $log_entry = "💰 Uang masuk: Rp." . number_format($received_amount, 0, ',', '.') . "\n";
    $log_entry .= "Akumulasi transaksi: Rp." . number_format($total_amount, 0, ',', '.') . "\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);

    // Kirimkan response dalam format JSON
    echo json_encode([
        'status' => 'success',
        'received_amount' => $received_amount,
        'total_amount' => $total_amount,
        'message' => 'Data berhasil diproses'
    ]);
    exit; // Mengakhiri script setelah pengolahan
}

// Jika tidak ada POST request, tampilkan log transaksi secara live
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Transaksi Bill Acceptor</title>
    <script>
        function fetchLogs() {
            fetch('backend.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'error') {
                        document.getElementById('logs').innerHTML = `<li style='color:red;'>${data.message}</li>`;
                        return;
                    }
                    let logs = data.logs.map(log => `<li>${log}</li>`).join('');
                    document.getElementById('logs').innerHTML = logs;
                    document.getElementById('last_received').innerText = 'Rp. ' + (data.last_received ? data.last_received.toLocaleString('id-ID') : '0');
                    document.getElementById('total').innerText = 'Rp. ' + (data.total ? data.total.toLocaleString('id-ID') : '0');
                })
                .catch(error => console.error('Error fetching logs:', error));
        }

        // Ambil data setiap 2 detik sekali
        setInterval(fetchLogs, 2000);

        // Panggil fetchLogs saat halaman pertama kali dimuat
        window.onload = fetchLogs;

        // Fungsi untuk mengirim data ke backend.php (untuk POST data)
        function sendData() {
            const received_amount = 50000;  // Misal uang yang diterima
            const total_amount = 100000;   // Total akumulasi transaksi

            fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'received_amount': received_amount,
                    'total_amount': total_amount
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Data berhasil diproses:', data);
                } else {
                    console.error('Terjadi kesalahan:', data.message);
                }
            })
            .catch(error => console.error('Error sending data:', error));
        }
    </script>
</head>
<body>
    <h1>Log Transaksi Bill Acceptor</h1>
    <h3>Uang Masuk Terakhir: <span id="last_received">Rp. 0</span></h3>
    <h3>Total Akumulasi: <span id="total">Rp. 0</span></h3>
    <h3>Log Transaksi (Live):</h3>
    <ul id="logs"></ul>

    <!-- Tombol untuk mengirimkan data POST -->
    <button onclick="sendData()">Kirim Data Transaksi</button>
</body>
</html>
