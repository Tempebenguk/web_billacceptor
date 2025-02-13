<?php
session_start();
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

    <h2>Transaksi Terkini (Real-Time):</h2>
    <div id="transaction_data"></div>

    <script>
        function updateTransactionData() {
            fetch('transaction.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Menampilkan data transaksi
                    document.getElementById('transaction_data').innerHTML = `
                        Uang Masuk: Rp. ${data.received_amount} <br>
                        Total Akumulasi: Rp. ${data.total_amount} <br>
                    `;
                } else {
                    document.getElementById('transaction_data').innerHTML = 'Error retrieving data';
                }
            });
        }
        setInterval(updateTransactionData, 1000);
    </script>
</body>
</html>
