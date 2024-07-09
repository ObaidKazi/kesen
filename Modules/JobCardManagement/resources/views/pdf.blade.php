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
            font-size: 10pt; /* Adjusted for better PDF rendering */
        }

        .container {
            width: 100%;
            margin: 20px auto;
            box-sizing: border-box;
        }

        .header,
        .footer {
            text-align: center;
            padding: 10px 0;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .client-info th,
        .client-info td,
        .job-details th,
        .job-details td,
        .additional-info th,
        .additional-info td {
            border: 1px solid #000;
            padding: 8px;
            word-wrap: break-word;
        }

        .job-details th,
        .client-info th,
        .additional-info th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .client-info td,
        .job-details td,
        .additional-info td {
            text-align: left;
        }

        .job-details th, 
        .job-details td {
            font-size: 8pt;
            text-align: center;
        }

        .additional-info td {
            font-size: 8pt;
        }

        @page {
            margin: 20px;
        }

        /* PDF-specific styles */
        @media print {
            body {
                font-size: 10pt;
            }

            .container {
                margin: 0;
            }

            .header,
            .footer {
                padding: 0;
            }

            .client-info th,
            .client-info td,
            .job-details th,
            .job-details td,
            .additional-info th,
            .additional-info td {
                padding: 5px;
            }
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @if ($job->estimate->client->client_metric->code == 'KCP')
                <img src="{{ public_path('img/kesen-communication.jpeg') }}" alt="Kesen Communication" width="100%">
            @elseif ($job->estimate->client->client_metric->code == 'KLB')
                <img src="{{ public_path('img/kesen-language-buea.jpeg') }}" alt="Kesen Language Bureau" width="100%">
            @elseif ($job->estimate->client->client_metric->code == 'LGS')
                <img src="{{ public_path('img/kesen-linguist-Servi-llp.jpeg') }}" alt="Kesen Linguist Servi LLP" width="100%">
            @else
                <img src="{{ public_path('img/kesen-linguist-system.jpeg') }}" alt="Kesen Linguist System" width="100%">
            @endif
            <br>
            <br>
            <br>
            <h2>JOB CARD</h2>
            <br>
        </div>
        <table class="client-info">
            <tr>
                <th>Client</th>
                <td>{{ $job->estimate->client->name ?? '' }}</td>
                <th>Job No.</th>
                <td>{{ $job->sr_no ?? '' }}</td>
            </tr>
            <tr>
                <th>Headline</th>
                <td>{{ $job->estimate->headline ?? '' }}</td>
                <th>Date</th>
                <td>{{ $job->date ? \Carbon\Carbon::parse($job->date)->format('j M Y') : '' }}</td>
            </tr>
            <tr>
                <th>Protocol No.</th>
                <td>{{ $job->protocol_no ?? '' }}</td>
                <th>Client Contact Person Name</th>
                <td>{{ $job->estimate->client_person->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Estimate No.</th>
                <td>{{ $job->estimate->estimate_no ?? '' }}</td>
                <th>Client Contact Person Number</th>
                <td>{{ $job->estimate->client_person->phone_no ?? '' }}</td>
            </tr>
            <tr>
                <th>Remarks: Quot No.</th>
                <td>{{ \Modules\EstimateManagement\App\Models\Estimates::whereIn('id', explode(',', $job->other_details))->get()->pluck('estimate_no')->implode(', ') ?? '' }}</td>
                <th>Handled By</th>
                <td>{{ $job->handle_by->name ?? '' }}</td>
            </tr>
        </table>
        <br>
        <br>
        <table class="job-details">
            <thead>
                <tr>
                    <th colspan="3">Langs.</th>
                    <th>Unit</th>
                    <th>Writer Code</th>
                    <th>Employee Code</th>
                    {{-- <th>Two Way QC Verified By</th> --}}
                    <th>PD</th>
                    <th>CR</th>
                    <th>C/NC</th>
                    <th>DV</th>
                    <th>F/QC</th>
                    <th>Sent Date</th>
                </tr>
            </thead>
            <tbody>
                @php $estimate_details_list=[];@endphp
                @php $temp_index=1;@endphp
                @php $pageBreakIndex=0;@endphp
                @php $lanIndex=0;@endphp
                @if (count($job->jobCard) != 0)
                    @foreach ($job->jobCard as $card)
                        <tr>
                            @if (!in_array($card->estimate_detail_id, $estimate_details_list))
                                @php $temp_index=1;@endphp
                                @php $lanIndex = $lanIndex==0?1:0;@endphp
                                @php $estimate_details_list[] = $card->estimate_detail_id; @endphp
                                <td rowspan="4" style={{$lanIndex == 0?"background-color:#fff;width:50px":"background-color:lightgrey;width:50px"}}>
                                
                                    {{ $card->estimateDetail->language->name??'' }}
                                </td>
                            @else
                                <td rowspan="4" style={{$lanIndex == 0?"background-color:#fff;width:50px;border-top-style:hidden;":"background-color:lightgrey;width:50px;border-top-style:hidden;"}}></td>
                                @php $temp_index+=1;@endphp
                            @endif

                            <td rowspan="4">PC {{ $temp_index }}</td>
                            <td style="background-color:grey;">T</td>
                            <td>{{ $card->t_unit }}</td>
                            <td>{{ Modules\WriterManagement\App\Models\Writer::where('id', $card->t_writer_code)->first()->code }}</td>
                            <td></td>
                            
                            <td>{{ $card->t_pd ? \Carbon\Carbon::parse($card->t_pd)->format('j M Y') : '' }}</td>
                            <td>{{ $card->t_cr ? \Carbon\Carbon::parse($card->t_cr)->format('j M Y') : '' }}</td>
                            <td>{{ $card->t_cnc }}</td>
                            <td>{{ $card->t_dv }}</td>
                            <td>{{ $card->t_fqc }}</td>
                            <td>{{ $card->t_sentdate ? \Carbon\Carbon::parse($card->t_sentdate)->format('j M Y') : '' }}</td>
                            @php $pageBreakIndex+=1;@endphp
                        </tr>
                        <tr>
                            <td>V</td>
                            <td>{{ $card->v_unit }}</td>
                            <td></td>
                            <td>{{ App\Models\User::where('id', $card->v_employee_code)->first()->code ?? '' }}</td>
                           
                            <td>{{ $card->v_pd ? \Carbon\Carbon::parse($card->v_pd)->format('j M Y') : '' }}</td>
                            <td>{{ $card->v_cr ? \Carbon\Carbon::parse($card->v_cr)->format('j M Y') : '' }}</td>
                            <td>{{ $card->v_cnc }}</td>
                            <td>{{ $card->v_dv }}</td>
                            <td>{{ $card->v_fqc }}</td>
                            <td>{{ $card->v_sentdate ? \Carbon\Carbon::parse($card->v_sentdate)->format('j M Y') : '' }}</td>
                            @php $pageBreakIndex+=1;@endphp
                        </tr>
                        <tr>
                            <td style="background-color:grey;">BT</td>
                            <td>{{ $card->bt_unit }}</td>
                            <td>{{ Modules\WriterManagement\App\Models\Writer::where('id', $card->bt_writer_code)->first()->code ?? '' }}</td>
                            <td></td>
                            
                            <td>{{ $card->bt_pd ? \Carbon\Carbon::parse($card->bt_pd)->format('j M Y') : '' }}</td>
                            <td>{{ $card->bt_cr ? \Carbon\Carbon::parse($card->bt_cr)->format('j M Y') : '' }}</td>
                            <td>{{ $card->bt_cnc }}</td>
                            <td>{{ $card->bt_dv }}</td>
                            <td>{{ $card->bt_fqc }}</td>
                            <td>{{ $card->bt_sentdate ? \Carbon\Carbon::parse($card->bt_sentdate)->format('j M Y') : '' }}</td>
                            @php $pageBreakIndex+=1;@endphp
                        </tr>
                        <tr>
                            <td>BTV</td>
                            <td>{{ $card->btv_unit }}</td>
                            <td></td>
                            <td>{{ App\Models\User::where('id', $card->btv_emp_code)->first()->code ?? '' }}</td>
                            <td>{{ $card->btv_pd ? \Carbon\Carbon::parse($card->btv_pd)->format('j M Y') : '' }}</td>
                            <td>{{ $card->btv_cr ? \Carbon\Carbon::parse($card->btv_cr)->format('j M Y') : '' }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> </td>
                            @php $pageBreakIndex+=1;@endphp
                        </tr>
                        @if($pageBreakIndex % 15 == 0 && $pageBreakIndex == 15 ) <!-- Adjust this number based on your page size and row height -->
                                </tbody>
                            </table>
                            <br>
                            <div class="page-break"></div>
                            <table class="job-details">
                                <thead>
                                    <tr>
                                        <th colspan="3">Langs.</th>
                                        <th>Unit</th>
                                        <th>Writer Code</th>
                                        <th>Employee Code</th>
                                        {{-- <th>Two Way QC Verified By</th> --}}
                                        <th>PD</th>
                                        <th>CR</th>
                                        <th>C/NC</th>
                                        <th>DV</th>
                                        <th>F/QC</th>
                                        <th>Sent Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @elseif($pageBreakIndex % 30 == 0 && $pageBreakIndex == 45 )
                                </tbody>
                            </table>
                            <br>
                            <div class="page-break"></div>
                            <table class="job-details">
                                <thead>
                                    <tr>
                                        <th colspan="3">Langs.</th>
                                        <th>Unit</th>
                                        <th>Writer Code</th>
                                        <th>Employee Code</th>
                                        {{-- <th>Two Way QC Verified By</th> --}}
                                        <th>PD</th>
                                        <th>CR</th>
                                        <th>C/NC</th>
                                        <th>DV</th>
                                        <th>F/QC</th>
                                        <th>Sent Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @elseif($pageBreakIndex % 30 == 0 && $pageBreakIndex > 45 )
                                </tbody>
                            </table>
                            <br>
                            <div class="page-break"></div>
                            <table class="job-details">
                                <thead>
                                    <tr>
                                        <th colspan="3">Langs.</th>
                                        <th>Unit</th>
                                        <th>Writer Code</th>
                                        <th>Employee Code</th>
                                        {{-- <th>Two Way QC Verified By</th> --}}
                                        <th>PD</th>
                                        <th>CR</th>
                                        <th>C/NC</th>
                                        <th>DV</th>
                                        <th>F/QC</th>
                                        <th>Sent Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @endif
                    @endforeach
                @else
                    @foreach (\Modules\EstimateManagement\App\Models\EstimatesDetails::where('estimate_id', $job->estimate_id)->get() as $card)
                        <tr>
                            @if (!in_array($card->id, $estimate_details_list))
                                @php $estimate_details_list[] = $card->id; @endphp
                                <td rowspan="4" style="font-size: 8pt">{{ $card->language->name??'' }}</td>
                            @endif

                            <td rowspan="4">PC</td>
                            <td style="font-size: 8pt;background-color:grey;">T</td>
                            
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt">

                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            @php $pageBreakIndex+=1;@endphp
                        </tr>  
                        <tr>
                            <td style="font-size: 8pt">V</td>
                            
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt">

                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            @php $pageBreakIndex+=1;@endphp
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;background-color:grey;">BT</td>
                            
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt">

                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            @php $pageBreakIndex+=1;@endphp
                        </tr>
                        <tr>
                            <td style="font-size: 8pt">BTV</td>
                            
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt">

                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            @php $pageBreakIndex+=1;@endphp
                        </tr>
                        @if($pageBreakIndex % 15 == 0 && $pageBreakIndex == 15 ) <!-- Adjust this number based on your page size and row height -->
                                </tbody>
                            </table>
                            <br>
                            <div class="page-break"></div>
                            <table class="job-details">
                                <thead>
                                    <tr>
                                        <th colspan="3">Langs.</th>
                                        <th>Unit</th>
                                        <th>Writer Code</th>
                                        <th>Employee Code</th>
                                        {{-- <th>Two Way QC Verified By</th> --}}
                                        <th>PD</th>
                                        <th>CR</th>
                                        <th>C/NC</th>
                                        <th>DV</th>
                                        <th>F/QC</th>
                                        <th>Sent Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @elseif($pageBreakIndex % 30 == 0 && $pageBreakIndex == 45 )
                                </tbody>
                            </table>
                            <br>
                            <div class="page-break"></div>
                            <table class="job-details">
                                <thead>
                                    <tr>
                                        <th colspan="3">Langs.</th>
                                        <th>Unit</th>
                                        <th>Writer Code</th>
                                        <th>Employee Code</th>
                                        {{-- <th>Two Way QC Verified By</th> --}}
                                        <th>PD</th>
                                        <th>CR</th>
                                        <th>C/NC</th>
                                        <th>DV</th>
                                        <th>F/QC</th>
                                        <th>Sent Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @elseif($pageBreakIndex % 30 == 0 && $pageBreakIndex > 45 )
                                </tbody>
                            </table>
                            <br>
                            <div class="page-break"></div>
                            <table class="job-details">
                                <thead>
                                    <tr>
                                        <th colspan="3">Langs.</th>
                                        <th>Unit</th>
                                        <th>Writer Code</th>
                                        <th>Employee Code</th>
                                        {{-- <th>Two Way QC Verified By</th> --}}
                                        <th>PD</th>
                                        <th>CR</th>
                                        <th>C/NC</th>
                                        <th>DV</th>
                                        <th>F/QC</th>
                                        <th>Sent Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
        <br>
        <table class="additional-info" >
            <tr>
                <td>Delivery Date</td>
                <td style="border-left-style: hidden;">
                    <strong>{{ $job->delivery_date ? \Carbon\Carbon::parse($job->delivery_date)->format('j M Y') : '' }}</strong>
                </td>
                <td>Bill No</td>
                <td style="border-left-style: hidden;font-weight: bold;">{{ $job->bill_no ?? '' }}</td>
            </tr>
            <tr>
                <td>Words / Units</td>
                <td style="border-left-style: hidden;font-weight: bold;">As per proforma</td>
                <td>Bill Date</td>
                <td style="border-left-style: hidden;font-weight: bold;">
                    {{ $job->bill_date ? \Carbon\Carbon::parse($job->bill_date)->format('j M Y') : '' }}</td>
            </tr>
            <tr>
                <td>Old Job No</td>
                <td style="border-left-style: hidden;font-weight: bold;">{{ $job->old_job_no ?? '' }}</td>
                <td>Bill sent on</td>
                <td style="border-left-style: hidden;font-weight: bold;">
                    {{ $job->sent_date ? \Carbon\Carbon::parse($job->sent_date)->format('j M Y') : '' }}</td>
            </tr>
            <tr>
                <td>Checked with Operator</td>
                <td style="border-left-style: hidden;"></td>
                <td>Informed To</td>
                <td style="border-left-style: hidden;font-weight: bold;">{{ $job->client_person->name ?? '' }}</td>
            </tr>

           
        </table>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Kesen Language Bureau. All rights reserved.</p>
        </div>
    </div>
</body>

</html>