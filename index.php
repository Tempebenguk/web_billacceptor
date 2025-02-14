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
    <style>
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
            width: 350px;
            height: 590px;
            margin: 0 auto;
            box-shadow: 0 0 10px #2323;
            margin-top: 50px;
            background: white;
        }
        .cardHolder {
            height: 300px;
            background: linear-gradient(to right, #6480ef, #7775e8, #806ce8);
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
            height: 40px;
            font-size: 14px;
            letter-spacing: 2px;
            color: white;
        }
        .stepHeading {
            height: 20px;
            font-size: 16px;
            font-weight: bolder;
            letter-spacing: 2px;
            color: white;
        }
        .card {
            height: 180px;
            width: 280px;
            background: white;
            margin: 0 auto;
            border-radius: 1.2em;
            margin-top: 25px;
            padding: 12px 20px;
        }
        .card > .part {
            height: 50px;
            margin-bottom: 4px;
        }
        .card > .top {
            display: flex;
            justify-content: flex-end;
        }
        .card > .top > img {
            height: 48px;
        }
        .infoheader {
            height: 20px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #95a5a6;
        }
        .card > .middle > .infocontent {
            justify-content: space-between;
            height: 30px;
        }
        .number {
            width: 150px;
        }
        .card > .middle > .infocontent > .num {
            height: 25px;
            font-size: 14px;
            letter-spacing: 2px;
            font-weight: bolder;
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
            font-weight: bolder;
            letter-spacing: 2px;
        }
        .status {
            height: 35px;
            width: 300px;
            margin: 0 auto;
            box-shadow: 0 0 10px #2323;
            margin-top: 16px;
            padding: 0 16px;
            font-size: 12px;
            letter-spacing: 2px;
            font-weight: bolder;
        }
        .status > i {
            color: #16a085;
            margin-right: 20px;
            font-size: 16px;
        }
        h5 {
            width: 220px;
            margin: 0 auto;
            padding: 8px;
            margin-top: 14px;
            border-bottom: 2px solid #bdc3c7;
            letter-spacing: 2px;
            font-size: 12px;
            margin-bottom: 12px;
        }
        .options {
            width: 250px;
            height: 75px;
            margin: 0 auto;
            justify-content: space-between;
        }
        .options > .opt {
            height: 75px;
            width: 75px;
            box-shadow: 0 0 10px #2323;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .options > .opt > .icon {
            height: 30px;
            color: #95a5a6;
            font-size: 20px;
        }
        .optname {
            height: 30px;
            font-size: 10px;
            color: #232323;
            letter-spacing: 2px;
            font-weight: bolder;
        }
        .payment {
            height: 80px;
            position: relative;
            top: 24px;
            box-shadow: 0 -5px 5px -5px #2323;
            justify-content: space-around;
        }
        .val {
            height: 40px;
            font-size: 24px;
            font-weight: bolder;
            letter-spacing: 2px;
            color: #6480ef;
        }
        .button {
            width: 120px;
            height: 35px;
            border-radius: 1.2em;
            background: linear-gradient(to right, #6480ef, #7775e8, #806ce8);
            color: white;
            font-weight: bolder;
            letter-spacing: 2px;
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
                <div class="heading center">LOG TRANSAKSI BILL ACCEPTOR</div>
                <div class="stepHeading center">Uang Masuk Terakhir</div>
                <div class="card">
                    <div class="top part">
                        <img src="https://i.imgrpost.com/imgr/2017/12/26/visa-1.png" alt="visa-1.png" border="0" />
                    </div>
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
        </div>
        <div class="status vcenter">
            <i class="fa fa-check" aria-hidden="true"></i>
            Log Transaksi (Live)
        </div>
        <ul id="logs"></ul>
    </div>
</body>
</html>