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
            .then(response => response.text())
            .then(data => {
                document.getElementById('transaction_data').innerHTML = data;
            });
        }

        setInterval(updateTransactionData, 1000);
    </script>
</body>
</html>
