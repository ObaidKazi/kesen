
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proforma Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            border: 2px solid #000;
        }
        header, footer {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%; /* Responsive table width */
            border-collapse: collapse;
            border: 1px solid black;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            font-size: 8px;
            text-align: left;
            word-wrap: break-word; /* Prevents text from overflowing */
        }
        th {
            font-size: 8px;
            background-color: #f2f2f2;
        }
        .header-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .sub-title {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .right-align {
            text-align: right;
        }
        .center-text {
            text-align: center;
        }
        .financials td {
            text-align: right; /* Aligns numbers to the right for better readability */
            padding-right: 20px; /* Provides some padding on the right for alignment */
        }
    </style>
</head>
<body>
    <header>
        <div class="header-title">{{$estimate->metrix}}</div>
        <div class="sub-title">PROFORMA</div>
    </header>

    <section>
        <div>No: Auto</div>
        <div class="right-align">F/P/7.2.3</div>
        <div class="right-align">Date: {{$estimate->created_at->format('d/m/Y')}}</div>

        <p><strong>Client Contact Person:</strong> {{$estimate->client_person->name}}</p>
        <p><strong>Address:</strong> {{$estimate->address}}</p>
        <p><strong>Ref:</strong> Quotation for Translation & Back Translation – Description</p>
        <p><strong>Mail Received on:</strong> {{$estimate->mail_received_on}}</p>
        <p><strong>Languages Required:</strong> {{$estimate->languages_required}}</p>

        <table border="1">
            <thead>
                <tr>
                    <th>Documents</th>
                    <th>Unit/Word (from drop down)</th>
                    <th>Rate</th>
                    <th>Translation</th>
                    <th>Verification</th>
                    <th>Layout Charges</th>
                    <th>Back Translation</th>
                    <th>Verification</th>
                    <th>Layout Charges</th>
                    <th>Lang. Total (Rs.)</th>
                    <th >Total (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>[Document]</td>
                    <td>{{$estimate->unit}}</td>
                    <td>{{$estimate->rate}}</td>
                    <td>{{$estimate->unit*$estimate->rate}}</td>
                    <td>{{$estimate->verification}}</td>
                    <td>{{$estimate->layout_charges}}</td>
                    <td>{{$estimate->bank_translation}}</td>
                    <td>{{$estimate->verification_2}}</td>
                    <td>{{$estimate->layout_charges_2}}</td>
                    <td>{{$estimate->lang_total}}</td>
                    <td colspan="3">{{(($estimate->unit*$estimate->rate)+($estimate->layout_charges)+($estimate->bank_translation)+($estimate->verification)+($estimate->verification_2)+($estimate->layout_charges_2))*($estimate->lang)}}</td>
                </tr>
                <tr class="financials">
                    <td colspan="10">Sub Total</td>
                    <td colspan="3"></td>
                </tr>
                <tr class="financials">
                    <td colspan="10">Discount</td>
                    <td colspan="3"></td>
                </tr>
                <tr class="financials">
                    <td colspan="10">Net Total</td>
                    <td colspan="3"></td>
                </tr>
                <tr class="financials">
                    <td colspan="10">GST (18%)</td>
                    <td colspan="3"></td>
                </tr>
                <tr class="financials">
                    <td colspan="10">Total</td>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>
    </section>

    <footer style="text-align: left;float: left">
        <p style="font-weight: bold;font-size: 12px">SAC Code: 998395</p>
        <p style="font-weight: bold;font-size: 12px">PS: TAXES AS APPLICABLE FROM TIME TO TIME.</p>
        <p style="font-size: 12px">The Job will be completed as per TAT provided.</p>
        <p style="font-size: 12px">Kindly let us have your approval.</p>
        <p style="font-size: 12px"> In case you need any clarification, please do not hesitate to call the undersigned.</p>
        <p style="font-size: 12px">Assuring you of our best services at all times.</p>
        <p >For <p style="font-weight: bold;font-size: 12px">{{$estimate->metrix}}</p></p>
        <div style="margin-top:20px; ">
            ____________________
        </div>
        <p>Authorized Signatory</p>
        <p style="float: right;font-weight: bold;font-size: 12px">Help us to Serve you Better</p>
    </footer>
</body>
</html>
