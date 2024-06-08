<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proforma Invoice {{ $estimate->client->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 10px;
            padding: 10px;
            line-height: 1;
            border: 2px solid #000;
        }

        header,
        footer {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            /* Responsive table width */
            border-collapse: collapse;
            border: 1px solid black;
        }

        td {
            border: 1px solid black;
            padding: 8px;
            font-size: 8px;
            text-align: left;
            word-break: break-word;
            /* Prevents text from overflowing */
        }

        th {
            border: 1px solid black;
            padding: 8px;
            font-size: 8px;
            text-align: left;
            font-size: 8px;
            background-color: #f2f2f2;
        }

        .header-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .sub-title {
            width: 100px;
            background-color: #c1c1c1;
            padding: 10px;
            font-size: 18px;
        }

        .right-align {
            text-align: right;
        }

        .center-text {
            text-align: center;
        }

        .financials td {
            text-align: center;
            /* Aligns numbers to the right for better readability */
        }

        .nowrap {
            white-space: nowrap;
            /* Prevents text from wrapping */
        }
    </style>
</head>
@php $sub_total=0; @endphp

<body>
    <header>
        @if ($estimate->metrics->code == 'KCP')
            <img src="{{ public_path('img/kesen-communication.jpeg') }}" alt="Iceberg Image" width="100%">
        @elseif ($estimate->metrics->code == 'KLB')
            <img src="{{ public_path('img/kesen-language-buea.jpeg') }}" alt="Iceberg Image" width="100%">
        @elseif ($estimate->metrics->code == 'LGS')
            <img src="{{ public_path('img/kesen-linguist-Servi-llp.jpeg') }}" alt="Iceberg Image" width="100%">
        @else
            <img src="{{ public_path('img/kesen-linguist-system.jpeg') }}" alt="Iceberg Image" width="100%">
        @endif

       
    </header>

    <section>
        <div style="margin-top:5px;">
            <div class="right-align" style="font-weight: bold;">F/P/7.2.3</div>
        </div>
        <div style="margin-top: 10px;margin-bottom: 10px">
            <span style="display: inline;font-weight: bold;">No: {{ $estimate->estimate_no }}</span>
            <span class="sub-title" style="margin-left: 13%;font-weight: bold;" >PROFORMA</span>
            <span style="float: right;font-weight: bold;font-size: 16px;display: inline">Date: {{ $estimate->created_at->format('d/m/Y') }}</span>
        </div>
        
        <div>
            <hr style="opacity: 0.5;">
        </div>
        <p> {{ $estimate->client_person->name }}</p>
        <p> {{ $estimate->client->name }}</p>
        <p>{{ $estimate->client->address }}</p>
        <p><strong>Ref:</strong> Quotation for {{ $estimate->headline }}</p>
        <p><strong>Mail Received on:</strong> {{ $estimate->date }}</p>
        <p><strong>Languages Required:</strong>
            @php $languages=[];@endphp
            @foreach ($estimate->details as $detail)
                @foreach ($detail->lang as $index => $language)
                    @if (!in_array($language, $languages))
                        @if ($index == 0)
                            {{ Modules\LanguageManagement\App\Models\Language::find($language)->name }}
                            @php $languages[] = $language; @endphp
                        @else
                            , {{ Modules\LanguageManagement\App\Models\Language::find($language)->name }}
                            @php $languages[] = $language; @endphp
                        @endif
                    @endif
                @endforeach
            @endforeach
        </p>
        @php $counter=6; @endphp
        <table>
            <thead>
                <tr>
                    <th>Documents</th>
                    <th>{{ ucfirst($estimate->type) }}</th>
                    <th>Rate</th>
                    <th>Translation</th>
                    @if ($estimate->details[0]->verification)
                        @php $counter=$counter+1; @endphp
                        <th>Verification</th>
                    @endif
                    @if ($estimate->details[0]->two_way_qc_t)
                        @php $counter=$counter+1; @endphp
                        <th>2 Way QC</th>
                    @endif
                    @if ($estimate->details[0]->layout_charges)
                        @php $counter=$counter+1; @endphp
                        <th>Layout Charges</th>
                    @endif
                    @if ($estimate->details[0]->back_translation)
                        @php $counter=$counter+1; @endphp
                        <th>Back Translation</th>
                    @endif
                    @if ($estimate->details[0]->verification_2)
                        @php $counter=$counter+1; @endphp
                        <th>Verification</th>
                    @endif
                    @if ($estimate->details[0]->two_way_qc_bt)
                        @php $counter=$counter+1; @endphp
                        <th>BT 2 Way QC</th>
                    @endif
                    @if ($estimate->details[0]->layout_charges_2)
                        @php $counter=$counter+1; @endphp
                        <th>Layout Charges</th>
                    @endif
                    <th style="width: 20%">Lang</th>
                    <th style="width: 20%">Amount (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estimate->details as $detail)
                    <tr>
                        <td>{{ $detail->document_name }}</td>
                        <td class="nowrap">{{ $detail->unit }}</td>
                        <td class="nowrap">{{ $detail->rate }}</td>
                        <td class="nowrap">{{ $detail->unit * $detail->rate }}</td>
                        @if ($estimate->details[0]->verification)
                            <td class="nowrap">{{ $detail->verification }}</td>
                        @endif
                        @if ($estimate->details[0]->two_way_qc_t)
                            <td class="nowrap">{{ $detail->two_way_qc_t }}</td>
                        @endif
                        @if ($estimate->details[0]->layout_charges)
                            <td class="nowrap">{{ $detail->layout_charges }}</td>
                        @endif
                        @if ($estimate->details[0]->back_translation)
                            <td class="nowrap">{{ $detail->back_translation }}</td>
                        @endif
                        @if ($estimate->details[0]->verification_2)
                            <td class="nowrap">{{ $detail->verification_2 }}</td>
                        @endif
                        @if ($estimate->details[0]->two_way_qc_bt)
                            <td class="nowrap">{{ $detail->two_way_qc_bt }}</td>
                        @endif
                        @if ($estimate->details[0]->layout_charges_2)
                            <td class="nowrap">{{ $detail->layout_charges_2 }}</td>
                        @endif
                        <td>{{ $detail->language }}</td>
                        <td class="nowrap">
                            {{ ($detail->unit * $detail->rate + $detail->layout_charges + $detail->back_translation + $detail->verification+ $detail->two_way_qc_t+ $detail->two_way_qc_bt + $detail->verification_2 + $detail->layout_charges_2) * count($detail->lang) }}
                        </td>
                        @php $sub_total=$sub_total+(($detail->unit*$detail->rate)+($detail->layout_charges)+($detail->back_translation)+($detail->verification)+($detail->two_way_qc_t)+($detail->two_way_qc_bt)+($detail->verification_2)+($detail->layout_charges_2))*count($detail->lang)@endphp
                    </tr>
                @endforeach

                <tr class="financials" style="background-color: #f0f0f0">
                    <td colspan="{{ $counter - 1 }}" style="font-size: 12px;font-weight: bold">Sub Total</td>
                    <td colspan="1" style="font-size: 8px;font-weight: bold">{{ $sub_total }}</td>
                </tr>
                @if ($estimate->discount)
                    <tr class="financials">
                        <td colspan="{{ $counter - 1 }}">Discount</td>
                        <td colspan="1" style="font-size: 6px;">{{ $estimate->discount ?? 0 }}</td>
                    </tr>
                    <tr class="financials" style="background-color: #f0f0f0">
                        <td colspan="{{ $counter - 1 }}">Net Total</td>
                        <td colspan="3" style="font-size: 6px;">{{ $sub_total - $estimate->discount }}</td>
                    </tr>
                @endif
                @php $net_total=$sub_total-($estimate->discount) @endphp
                <tr class="financials">
                    <td colspan="{{ $counter - 1 }}">GST (18%)</td>
                    <td colspan="3" style="font-size: 6px;">{{ ($net_total / 100) * 18 }}</td>
                </tr>
                <tr class="financials" style="background-color: #f0f0f0">
                    <td colspan="{{ $counter - 1 }}" style="font-size: 14px;font-weight: bold">Total</td>
                    <td colspan="1" style="font-size: 6px;font-weight: bold">{{ $net_total + ($net_total / 100) * 18 }}
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <footer style="text-align: left;float: left;margin-top: 10px">
        <p style="font-weight: bold;font-size: 12px">SAC Code: 998395</p>
        <p style="font-weight: bold;font-size: 12px">PS: TAXES AS APPLICABLE FROM TIME TO TIME.</p>
        <p style="font-size: 12px">The Job will be completed as per TAT provided.</p>
        <p style="font-size: 12px">Kindly let us have your approval.</p>
        <p style="font-size: 12px"> In case you need any clarification, please do not hesitate to call the undersigned.
        </p>
        <p style="font-size: 12px">Assuring you of our best services at all times.</p>
        <div>
            <div style="display: block">
                <p style="display: inline">For </p>
                (<p style="font-weight: bold;display: inline">{{ $estimate->metrics->name }}</p>)
            </div>
            <div style="margin-top:35px;">
                _________________________
            </div>
            <div >
                <span style="display: inline;padding-left: 35px;">Authorized Signatory</span>
                <span style="float: right;font-weight: bold;font-size: 12px;display: inline">Help us to Serve you Better
                </span>
            </div>
        </div>
    </footer>
</body>

</html>
