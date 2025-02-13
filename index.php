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
