<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesen Language Bureau Job Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            border: 1px solid #000;
        }
        .header, .footer {
            text-align: center;
            padding: 10px 0;
        }
        .header img {
            height: 50px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .job-details {
            width: 100%;
            border-collapse: collapse;
        }
        .job-details td, .job-details th {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .job-details th {
            background-color: #f2f2f2;
        }
        .client-info, .job-info, .additional-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .client-info td, .client-info th, .job-info td, .job-info th, .additional-info td, .additional-info th {
            border: 1px solid #000;
            padding: 8px;
        }
        .client-info th, .job-info th, .additional-info th {
            background-color: #f2f2f2;
        }
        .client-info td, .job-info td, .additional-info td {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{asset(config('adminlte.logo_img'))}}" alt="Kesen Language Bureau Logo">
            <h1>Kesen Language Bureau</h1>
            <h2>JOB CARD</h2>
        </div>
        <table class="client-info">
            <tr>
                <th>Client</th>
                <td>{{$job->client->name??''}}</td>
                <th>Job No.</th>
                <td>{{$job->sr_no??''}}</td>
            </tr>
            <tr>
                <th>Headline</th>
                <td>{{$job->description??''}}</td>
                <th>Date</th>
                <td>{{$job->date??''}}</td>
            </tr>
            <tr>
                <th>Protocol No.</th>
                <td>{{$job->protocol_no??''}}</td>
                <th>P.O. No.</th>
                <td></td>
            </tr>
            <tr>
                <th>Estimate No.</th>
                <td>{{$job->estimate->estimate_no??''}}</td>
                <th>Client Contact Person Name</th>
                <td>{{$job->client_person->name??''}}</td>
            </tr>
            <tr>
                <th></th>
                <td></td>
                <th>Client Contact Person Number</th>
                <td>{{$job->client_person->phone_no??''}}</td>
            </tr>
            <tr>
                <th></th>
                <td></td>
                <th>Handled By</th>
                <td>{{$job->handle_by->name??''}}</td>
            </tr>
        </table>
        <table class="job-details">
            <thead>
                <tr>
                    <th colspan="2">Langs.</th>
                    
                    <th>Unit</th>
                    <th>Writer Code</th>
                    <th>Employee Code</th>
                    <th>PD</th>
                    <th>CR</th>
                    <th>C/NC</th>
                    <th>DV</th>
                    <th>F/QC</th>
                    <th>Sent Date</th>
                </tr>
            </thead>
            <tbody>
                <!-- Bengali -->
                <tr>
                    <td rowspan="4">Bengali</td>
                    <td>T</td>
                    <td>11</td>
                    <td>SAU</td>
                    <td>RIB</td>
                    <td>23 Jan 2024</td>
                    <td>24 Jan 2024</td>
                    <td>C</td>
                    <td>PANDU</td>
                    <td>27 Jan 2024</td>
                    <td>27 Jan 2024</td>
                </tr>
                <tr>
                    <td>BT</td>
                    <td></td>
                    <td>CED</td>
                    <td></td>
                    <td>24 Jan 2024</td>
                    <td>27 Jan 2024</td>
                    <td>C</td>
                    <td>PANDU</td>
                    <td>27 Jan 2024</td>
                    <td>27 Jan 2024</td>
                </tr>
                <tr>
                    <td>V</td>
                    <td></td>
                    <td>CED</td>
                    <td></td>
                    <td>24 Jan 2024</td>
                    <td>27 Jan 2024</td>
                    <td>C</td>
                    <td>PANDU</td>
                    <td>27 Jan 2024</td>
                    <td>27 Jan 2024</td>
                </tr>
                <tr>
                    <td>BTV</td>
                    <td></td>
                    <td>CED</td>
                    <td></td>
                    <td>24 Jan 2024</td>
                    <td>27 Jan 2024</td>
                    <td>C</td>
                    <td>PANDU</td>
                    <td>27 Jan 2024</td>
                    <td>27 Jan 2024</td>
                </tr>
                <!-- Gujarati -->
                <tr>
                    <td rowspan="4">Gujarati</td>
                    <td>T</td>
                    <td>2</td>
                    <td>VIM</td>
                    <td>SHM</td>
                    <td>23 Jan 2024</td>
                    <td>24 Jan 2024</td>
                    <td>C</td>
                    <td>PANDU</td>
                    <td>27 Jan 2024</td>
                    <td>27 Jan 2024</td>
                </tr>
                <tr>
                    <td>BT</td>
                    <td></td>
                    <td></td>
                    <td>RAL</td>
                    <td></td>
                    <td>23 Jan 2024</td>
                    <td>24 Jan 2024</td>
                    <td>C</td>
                    <td>PANDU</td>
                    <td>27 Jan 2024</td>
                </tr>
                <tr>
                    <td>V</td>
                    <td></td>
                    <td>CED</td>
                    <td></td>
                    <td>24 Jan 2024</td>
                    <td>27 Jan 2024</td>
                    <td>C</td>
                    <td>PANDU</td>
                    <td>27 Jan 2024</td>
                    <td>27 Jan 2024</td>
                </tr>
                <tr>
                    <td>BTV</td>
                    <td></td>
                    <td>CED</td>
                    <td></td>
                    <td>24 Jan 2024</td>
                    <td>27 Jan 2024</td>
                    <td>C</td>
                    <td>PANDU</td>
                    <td>27 Jan 2024</td>
                    <td>27 Jan 2024</td>
                </tr>
            </tbody>
        </table>
        <table class="additional-info">
            <tr>
                <td>Delivery Date</td>
                <td style="border-left-style: hidden;"><strong>27 Jan 2024</strong></td>
                <td>Bill No</td>
                <td style="border-left-style: hidden;">0931</td>
            </tr>
            <tr> 
                <td>Words / Units</td>
                <td style="border-left-style: hidden;">As per proforma</td>
                <td>Bill Date</td>
                <td style="border-left-style: hidden;">13 Mar 2024</td>
            </tr>
            <tr>
                <td>Old Job No</td>
                <td style="border-left-style: hidden;"></td>
                <td>Bill sent on</td>
                <td style="border-left-style: hidden;">13 Mar 2024</td>
            </tr>
            <tr>
                <td>Checked with Operator</td>
                <td style="border-left-style: hidden;"></td>
                <td>Informed To</td>
                <td style="border-left-style: hidden;">PRASAD BANGARI</td>
            </tr>
            <tr>
                <td>Remarks: Quot No. 5312</td>
                <td style="border-left-style: hidden;"></td>
                <td></td>
                <td style="border-left-style: hidden;"></td>
            </tr>
        </table>
        <div class="footer">
            <p>Handled By: Milind Chaubal</p>
        </div>
    </div>
</body>
</html>
