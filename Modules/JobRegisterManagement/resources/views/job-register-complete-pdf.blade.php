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
    <p style="float: right">Date: {{date('Y-m-d')}}</p>
    <br>
    <p>To:</p>
    <p>{{$jobRegister->estimate->client_person->name}}</p>
    <p>{{$jobRegister->estimate->client->name}}</p>
    <p>Document Name: {{$jobRegister->estimateDetail->document_name}}</p>
    <p>Quotation No.: {{\Modules\EstimateManagement\App\Models\Estimates::whereIn('id', explode(',', $jobRegister->other_details))->get()->pluck('estimate_no')->implode(', ') ?? '' }}</p>
    <p>Project Manager: {{$jobRegister->handle_by->name}}</p>
    <p>Dear Sir/Madam,</p>
    <p>Thank You for giving us an opportunity to serve you!</p>
    <p>We have initiated your document having Job No. {{$jobRegister->sr_no}} for {{ implode(',',array_unique($languages_list)) }}</p>
    <p>We assure you to complete this Job by {{$jobRegister->date}} </p>
    <p>Please Quote our Job No. {{$jobRegister->sr_no}} for all our future correspondence/ corrections / amendments suggestions related to this Job.</p>
    <p>In case of any queries please feel free to mail at kesen@kesen.in or call us on:
    +91-22-4034 8888 or Mr. Keith Myers on +91 98210 22327.</p>
    <p>Assuring you of our best services at all times.</p>
    <p>Warm Regards,</p>
    <p>KeSen Group of Companies</p>
  </div>
</body>
</html>
