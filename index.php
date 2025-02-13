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
        setInterval(fetchLogs, 2000);
        window.onload = fetchLogs;
    </script>
</head>
<body>
    <h1>Log Transaksi Bill Acceptor</h1>
    <h3>Uang Masuk Terakhir: <span id="last_received">Rp. 0</span></h3>
    <h3>Total Akumulasi: <span id="total">Rp. 0</span></h3>
    <h3>Log Transaksi (Live):</h3>
    <ul id="logs"></ul>
</body>
</html>