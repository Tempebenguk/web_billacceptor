<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Transaksi Bill Acceptor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Quicksand", sans-serif;
        }
        body {
            background: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }
        .mainContainer {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .cardHolder {
            background: linear-gradient(to right, #6480ef, #7775e8, #806ce8);
            padding: 1rem;
            text-align: center;
        }
        .heading {
            font-size: 1.2rem;
            color: white;
            margin-bottom: 0.5rem;
        }
        .stepHeading {
            font-size: 1rem;
            color: white;
            font-weight: bold;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            margin: 1rem auto;
            width: 90%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card > .part {
            margin-bottom: 1rem;
        }
        .infoheader {
            font-size: 0.9rem;
            color: #95a5a6;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .infocontent {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
        }
        .status {
            background: white;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 1rem;
            border-radius: 5px;
        }
        .status > i {
            color: #16a085;
            margin-right: 0.5rem;
        }
        #logs {
            list-style: none;
            padding: 1rem;
            margin: 0;
        }
        #logs li {
            background: #f9f9f9;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border-radius: 5px;
            font-size: 0.9rem;
            color: #333;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .mainContainer {
                width: 100%;
                margin: 1rem;
            }
            .card {
                width: 100%;
            }
            .heading {
                font-size: 1rem;
            }
            .stepHeading {
                font-size: 0.9rem;
            }
            .infocontent {
                font-size: 1rem;
            }
        }
    </style>
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
    <div class="mainContainer">
        <div class="cardHolder">
            <div class="header">
                <div class="heading">LOG TRANSAKSI BILL ACCEPTOR</div>
                <div class="stepHeading">Uang Masuk Terakhir</div>
            </div>
            <div class="card">
                <div class="middle part">
                    <div class="infoheader">JUMLAH UANG MASUK TERAKHIR</div>
                    <div class="infocontent" id="last_received">Rp. 0</div>
                </div>
                <div class="bottom part">
                    <div class="infoheader">TOTAL AKUMULASI</div>
                    <div class="infocontent" id="total">Rp. 0</div>
                </div>
            </div>
        </div>
        <div class="status">
            <i class="fa fa-check" aria-hidden="true"></i>
            Log Transaksi (Live)
        </div>
        <ul id="logs"></ul>
    </div>
</body>
</html>