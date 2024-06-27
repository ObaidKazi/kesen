<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Advice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: green;
            margin: 0;
        }
        .header p {
            margin: 0;
        }
        .info-table, .payment-table {
            width: 100%;
            border-collapse: collapse;
            
        }
        .info-table td, .payment-table th, .payment-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .info-table td:nth-child(2), .payment-table th, .payment-table td {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
        }
        .amount-words {
            font-weight: bold;
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Linguistic Systems</h1>
            <p>KANAKIA WALL STREET, A WING, 904-905, 9TH FLOOR, ANDHERI KURLA ROAD, CHAKALA, ANDHERI EAST, MUMBAI - 400 093</p>
            <p>022 4034 8888 / 022 4034 8801 / 022 4034 8845</p>
            <p>PAN NO: AADFL1698N GST NO: 27AADFL1698N1ZP</p>
        </div>
        <h2>PAYMENT ADVICE</h2>
        <table class="info-table">
            <tr>
                <td >Zahid Ansari</td>
                <td style="width: 212px;">Payment Date : <b>29 May 2024</b></td>
            </tr>
            <tr>
                <td >An Electronic payment has been done into your account being translation charges for the jobs listed below :</td>
                <td >Payment Method : <b>NEFT/TPT</b></td>
            </tr>
            <tr>
                <td ></td>
                <td >NEFT Reference : <b>NEFT</b></td>
            </tr>
            <tr>
                <td ></td>
                <td >Amount : <b>INR 11407</b></td>
            </tr>
        </table>
        <table class="payment-table">
            <tr>
                <th>Month</th>
                <th>Job No.</th>
                <th>Description</th>
                <th>Units</th>
                <th>Language</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
            @foreach ($job_card as $job)
                
            @endforeach
            <tr>
                <td>Mar 2024</td>
                <td>37889</td>
                <td>V</td>
                <td>2</td>
                <td>Urdu</td>
                <td>20</td>
                <td>40</td>
            
            <tr class="total-row">
                <td colspan="6">Total</td>
                <td>12675</td>
            </tr>
            <tr class="total-row">
                <td colspan="6">TDS 10%</td>
                <td>1268</td>
            </tr>
            <tr class="total-row">
                <td colspan="6">Total</td>
                <td>11407</td>
            </tr>
            <tr class="total-row">
                <td colspan="6">Grand Total</td>
                <td>11407</td>
            </tr>
        </table>
        <p class="amount-words">Rupees : Eleven Thousand, Four Hundred And Seven Only</p>
    </div>
</body>
</html>
