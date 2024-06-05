
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proforma Invoice {{$estimate->client->name}}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 10px;
            padding: 10px;
            border: 2px solid #000;
        }
        header, footer {
            width: 100%;
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
            text-align: center; /* Aligns numbers to the right for better readability */
            
        }
    </style>
</head>
@php $sub_total=0; @endphp
<body>
    <header>
        <div class="header-title">{{$estimate->metrics->name}}</div>
        <div class="sub-title">PROFORMA</div>
    </header>

    <section>
        <div>No: {{$estimate->estimate_no}}</div>
        <div class="right-align">F/P/7.2.3</div>
        <div class="right-align">Date: {{$estimate->created_at->format('d/m/Y')}}</div>

        <p><strong>Client Contact Person:</strong> {{$estimate->client_person->name}}</p>
        <p><strong>Address:</strong> {{$estimate->client->address}}</p>
        <p><strong>Ref:</strong> Quotation for {{$estimate->headline}}</p>
        <p><strong>Mail Received on:</strong> {{$estimate->date}}</p>
        <p><strong>Languages Required:</strong>
        @php $languages=[];@endphp
        @foreach ($estimate->details as $detail)
          @foreach ($detail->lang as $index=>$language)
            @if(!in_array($language,$languages))
                @if($index==0)
                    {{Modules\LanguageManagement\App\Models\Language::find($language)->name}}
                    @php $languages[] = $language; @endphp
                @else
                    , {{Modules\LanguageManagement\App\Models\Language::find($language)->name}}
                    @php $languages[] = $language; @endphp
                @endif
            @endif 
          @endforeach
        @endforeach
        </p>

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
                    <th>Lang</th>
                    <th >Total (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estimate->details as $detail)
                <tr>
                    <td>{{$detail->document_name}}</td>
                    <td>{{strtoupper($detail->type)}} - {{$detail->unit}}</td>
                    <td>{{$detail->rate}}</td>
                    <td>{{$detail->unit*$detail->rate}}</td>
                    <td>{{$detail->verification}}</td>
                    <td>{{$detail->layout_charges}}</td>
                    <td>{{$detail->back_translation}}</td>
                    <td>{{$detail->verification_2}}</td>
                    <td>{{$detail->layout_charges_2}}</td>
                    <td>{{count($detail->lang)}}</td>
                    <td colspan="3">{{(($detail->unit*$detail->rate)+($detail->layout_charges)+($detail->back_translation)+($detail->verification)+($detail->verification_2)+($detail->layout_charges_2))*count($detail->lang)}}</td>
                    @php $sub_total=$sub_total+(($detail->unit*$detail->rate)+($detail->layout_charges)+($detail->back_translation)+($detail->verification)+($detail->verification_2)+($detail->layout_charges_2))*count($detail->lang)@endphp
                </tr>    
                @endforeach
                
                <tr class="financials" style="background-color: #f0f0f0">
                    <td colspan="10" style="font-size: 12px;font-weight: bold">Sub Total</td>
                    <td colspan="3" style="font-size: 8px;font-weight: bold">{{$sub_total}}</td>
                </tr>
                <tr class="financials">
                    <td colspan="10">Discount</td>
                    <td colspan="3"  style="font-size: 6px;">{{$estimate->discount??0}}</td>
                </tr>
                <tr class="financials" style="background-color: #f0f0f0">
                    <td colspan="10">Net Total</td>
                    <td colspan="3"  style="font-size: 6px;">{{$sub_total-($estimate->discount)}}</td>
                    @php $net_total=$sub_total-($estimate->discount) @endphp
                </tr>
                <tr class="financials">
                    <td colspan="10">GST (18%)</td>
                    <td colspan="3"  style="font-size: 6px;">{{$net_total/100*18}}</td>
                </tr>
                <tr class="financials" style="background-color: #f0f0f0">
                    <td colspan="10"  style="font-size: 14px;font-weight: bold">Total</td>
                    <td colspan="3"  style="font-size: 6px;font-weight: bold">{{$net_total+($net_total/100*18)}}</td>
                </tr>
            </tbody>
        </table>
    </section>

    <footer style="text-align: left;float: left;margin-top: 10px">
        <p style="font-weight: bold;font-size: 12px">SAC Code: 998395</p>
        <p style="font-weight: bold;font-size: 12px">PS: TAXES AS APPLICABLE FROM TIME TO TIME.</p>
        <p style="font-size: 12px">The Job will be completed as per TAT provided.</p>
        <p style="font-size: 12px">Kindly let us have your approval.</p>
        <p style="font-size: 12px"> In case you need any clarification, please do not hesitate to call the undersigned.</p>
        <p style="font-size: 12px">Assuring you of our best services at all times.</p>
        <div style="display: block">
            <p style="display: inline">For </p>
            (<p style="font-weight: bold;display: inline">{{$estimate->metrics->name}}</p>)
        </div>
        <div style="margin-top:35px; ">
            _________________________
        </div>
        <div style="display: block">
            <p style="display: inline;padding-left: 35px;">Authorized Signatory</p>
            <p style="float: right;font-weight: bold;font-size: 12px;display: inline">Help us to Serve you Better</p>
        </div>
        
        
    </footer>
</body>
</html>
