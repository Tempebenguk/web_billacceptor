<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Acceptor Dashboard</title>
    <script>
        function fetchData() {
            fetch('backend.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'error') {
                        document.getElementById('logs').innerHTML = <li style='color:red;'>${data.message}</li>;
                        return;
                    }
                    document.getElementById('last_received').innerText = 'Rp. ' + (data.last_received ? data.last_received.toLocaleString('id-ID') : '0');
                    document.getElementById('total').innerText = 'Rp. ' + (data.total ? data.total.toLocaleString('id-ID') : '0');
                    let logs = data.logs.map(log => <li>${log}</li>).join('');
                    document.getElementById('logs').innerHTML = logs;
                })
                .catch(error => console.error('Error fetching data:', error));
        }
        setInterval(fetchData, 2000);
        window.onload = fetchData;
    </script>
</head>
<body>
    <h1>Bill Acceptor Dashboard</h1>
    <h2>Uang Masuk: <span id="last_received">Rp. 0</span></h2>
    <h2>Total Akumulasi: <span id="total">Rp. 0</span></h2>
    <h3>Log Transaksi:</h3>
    <ul id="logs"></ul>
</body>
</html>