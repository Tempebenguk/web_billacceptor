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
                    
                    if (typeof data.last_received === 'number') {
                        document.getElementById('last_received').textContent = `Rp. ${data.last_received.toLocaleString()}`;
                    } else {
                        document.getElementById('last_received').textContent = 'Rp. 0';
                    }

                    if (typeof data.total_amount === 'number') {
                        document.getElementById('total_amount').textContent = `Rp. ${data.total_amount.toLocaleString()}`;
                    } else {
                        document.getElementById('total_amount').textContent = 'Rp. 0';
                    }
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
    <h3>Total Akumulasi: <span id="total_amount">Rp. 0</span></h3>
    <h3>Log Transaksi (Live):</h3>
    <ul id="logs"></ul>
</body>
</html>