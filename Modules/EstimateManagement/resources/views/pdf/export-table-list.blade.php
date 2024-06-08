<!DOCTYPE html>
<html lang="en">
@php
    $heads = [
        [
            'label' => 'ID',
        ],
        [
            'label' => 'Estimate No',
        ],
        [
            'label' => 'Metrix',
        ],
        [
            'label' => 'Client Name',
        ],
        [
            'label' => 'Contact Person Name',
        ],
        

        [
            'label' => 'Headline',
        ],
        // [
        //     'label' => 'Amount',
        // ],

        [
            'label' => 'Currency',
        ],
        [
            'label' => 'Status',
        ],
        [
            'label' => 'Created By',
        ],
        // [
        //     'label' => 'Action',
        // ],
        
    ];

@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .badge {
            padding: 10px;
            border-radius: 4px;
            color: white;
            margin-right: 10px;
        }
        .badge-primary {
            background-color: #007bff;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .status-pending {
            background-color: #ffc107;
        }
        .status-approved {
            background-color: #28a745;
        }
        .status-rejected {
            background-color: #dc3545;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            text-decoration: none;
            color: black;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
    </style>
    <title>Document</title>
</head>
<body >
&nbsp;&nbsp;<span class="badge badge-primary" >Total Estimate: {{ $estimates->count() }}</span>
<span class="badge badge-success">Total Approved: {{ $estimates_approved_count }}</span>
<span class="badge badge-danger">Total Rejected: {{ $estimates_rejected_count }}</span>

<table style=" margin-top:20px">
    <thead>
        <tr>
            @foreach ($heads as $head)
                <th>{{ $head['label'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($estimates as $index=>$row)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $row->estimate_no }}</td>
            <td>{{ App\Models\Metrix::where('id',$row->metrix)->first()->code }}</td>
            <td>{{ Modules\ClientManagement\App\Models\Client::where('id',$row->client_id)->first()->name??'';}}</td>
            <td>{{  Modules\ClientManagement\App\Models\ContactPerson::where('id',$row->client_contact_person_id)->first()->name??'';}}</td>
            <td>{{ $row->headline }}</td>
            <td>{{ $row->currency }}</td>
            <td class="{{ $row->status == 0 ? 'status-pending' : ($row->status == 1 ? 'status-approved' : 'status-rejected') }}">
                {{ $row->status == 0 ? 'Pending' : ($row->status == 1 ? 'Approved' : 'Rejected') }}
            </td>
            <td>{{ App\Models\User::where('id',$row->created_by)->first()->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
