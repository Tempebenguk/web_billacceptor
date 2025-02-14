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
        /* CSS yang sudah Anda miliki */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Quicksand", sans-serif;
        }
        body {
            background: #ecf0f1;
        }
        .mainContainer {
            max-width: 500px;
            width: 100%;
            height: auto;
            margin: 20px auto;
            box-shadow: 0 0 10px #2323;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }
        .cardHolder {
            height: auto;
            background: linear-gradient(to right, #6480ef, #7775e8, #806ce8);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .vcenter {
            display: flex;
            align-items: center;
        }
        .heading {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 2px;
            color: white;
            text-align: center;
        }
        .stepHeading {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
            color: white;
            text-align: center;
            margin: 10px 0;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card > .part {
            height: 50px;
            margin-bottom: 10px;
        }
        .infoheader {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #95a5a6;
            text-align: center;
        }
        .card > .middle > .infocontent {
            justify-content: space-between;
            height: 30px;
        }
        .number {
            width: 150px;
        }
        .card > .middle > .infocontent > .num {
            font-size: 20px;
            letter-spacing: 2px;
            font-weight: bold;
            text-align: center;
        }
        .card > .bottom {
            display: flex;
            justify-content: space-between;
        }
        .holderInfo {
            width: 150px;
        }
        .holderInfo > .name, .expDate > .date {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .status {
            margin-top: 20px;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            background-color: #16a085;
            color: white;
            border-radius: 5px;
        }
        h5 {
            text-align: center;
            padding: 8px;
            margin-top: 14px;
            border-bottom: 2px solid #bdc3c7;
            letter-spacing: 2px;
            font-size: 14px;
            margin-bottom: 12px;
        }
        .options {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .options > .opt {
            height: 75px;
            width: 75px;
            box-shadow: 0 0 10px #2323;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .options > .opt > .icon {
            font-size: 24px;
            color: #95a5a6;
        }
        .optname {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
            text-align: center;
        }
        .payment {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }
        .val {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #6480ef;
        }
        .button {
            width: 120px;
            height: 35px;
            border-radius: 20px;
            background: linear-gradient(to right, #6480ef, #7775e8, #806ce8);
            color: white;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 20px;
        }

        /* Responsiveness */
        @media (max-width: 600px) {
            .mainContainer {
                width: 90%;
                padding: 15px;
            }

            .heading, .stepHeading, .infoheader {
                font-size: 14px;
            }

            .card {
                padding: 10px;
            }

            .status {
                font-size: 12px;
            }

            .payment {
                flex-direction: column;
            }

            .options {
                flex-direction: column;
                align-items: center;
            }

            .options > .opt {
                width: 100%;
                margin-bottom: 10px;
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
            <div class="heading">LOG TRANSAKSI BILL ACCEPTOR</div>
            <div class="stepHeading">Uang Masuk Terakhir</div>
            <div class="card">
                <div class="middle part">
                    <div class="infoheader vcenter">JUMLAH UANG MASUK TERAKHIR</div>
                    <div class="infocontent number vcenter">
                        <div class="num center" id="last_received">Rp. 0</div>
                    </div>
                </div>
                <div class="bottom part">
                    <div class="holderInfo">
                        <div class="infoheader vcenter">TOTAL AKUMULASI</div>
                        <div class="infocontent name vcenter" id="total">Rp. 0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="status vcenter">
            <i class="fa fa-check" aria-hidden="true"></i>
            Log Transaksi (Live)
        </div>
        <ul id="logs"></ul>
    </div>
</body>
</html>
