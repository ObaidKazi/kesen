<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Confirmation Letter</title>
  <style>
    body {
      font-family: Arial, sans-serif; /* Set a default font */
      margin: 0; /* Remove default margin */
      padding: 20px; /* Add some padding for aesthetics */
    }

    h1 {
      text-align: center; /* Center all headings and paragraphs */
    }

    .container {
      max-width: 600px; /* Limit the width for responsiveness */
      margin: 0 auto; /* Center the container horizontally */
      border: 1px solid #ddd; /* Add a subtle border for visual separation */
      padding: 20px; /* Add padding inside the container */
    }
  </style>
</head>
@php $languages_list=[] @endphp
@foreach ($jobRegister->estimate_details()->distinct('lang')->get() as $index=>$details )    
    @php $languages_list[]=Modules\LanguageManagement\App\Models\Language::where('id',$details->lang)->first()->name @endphp
@endforeach
         
<body>
  <div class="container">
    <h1>Confirmation Letter</h1>
    <p style="float: right">Date: {{\Carbon\Carbon::parse(date('Y-m-d'))->format('j M Y')}}</p>
    <br>
    <p style="margin-bottom: 20px;">To:</p>

    <p style="line-height: 0.5;">{{$jobRegister->estimate->client_person->name}}</p>
    <p style="line-height: 0.5;">{{$jobRegister->estimate->client->name}}</p>
    <p style="line-height: 0.5;">Document Name: {{$jobRegister->estimateDetail->document_name}}</p>
    <p style="line-height: 0.5;">Quotation No.: {{\Modules\EstimateManagement\App\Models\Estimates::whereIn('id', explode(',', $jobRegister->other_details))->get()->pluck('estimate_no')->implode(', ') ?? '' }}</p>
    <p style="line-height: 0.5;margin-bottom:40px;">Project Manager: {{$jobRegister->handle_by->name}}</p>

    <p>Dear Sir/Madam,</p>
    <p>Thank You for giving us an opportunity to serve you!</p>
    <p style="margin-bottom: 0;">We have initiated your document having <strong>Job No. {{$jobRegister->sr_no}}</strong> for <strong>{{ implode(',',array_unique($languages_list)) }}</strong>.</pstyle>
    <p style="margin-top: 0;">We assure you to complete this Job by <strong>{{\Carbon\Carbon::parse($jobRegister->date)->format('j M Y')}}</strong> </p>
    <p style="line-height: 1.3;">Please Quote our <strong>Job No. {{$jobRegister->sr_no}}</strong> for all our future correspondence/ corrections / amendments suggestions related to this Job.</p>
    <p style="line-height: 1.3;">In case of any queries please feel free to mail at <a href="mailto:kesen@kesen.in">kesen@kesen.in</a> or call us on:
    <strong><a href="tel:2240348888" style="text-decoration:none;">+91-22-4034 8888</a></strong> or <strong>Mr. Keith Myers</strong> on <strong><a href="tel:98210 22327" style="text-decoration: none;">+91 98210 22327</a></strong>.</p>
    <p>Assuring you of our best services at all times.</p>
    <p style="margin-bottom: 0;">Warm Regards,</p>
    <p style="margin-top: 0;"><strong>KeSen Group of Companies</strong> </p>
  </div>
</body>
</html>
