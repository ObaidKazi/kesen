@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php $estimates=Modules\EstimateManagement\App\Models\Estimates::where('status',1)->get(); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp
@php $users=App\Models\User::where('email','!=','developer@kesen.com')->where('id','!=',Auth()->user()->id)->get(); @endphp
@php
    $config = [
        "title" => "Select Estimate Number",
        "liveSearch" => true,
        "placeholder" => "Search Estimate Number...",
        "showTick" => true,
        "actionsBox" => true
    ]
@endphp
@if ($layoutHelper->isLayoutTopnavEnabled())
    @php($def_container_class = 'container')
@else
    @php($def_container_class = 'container-fluid')
@endif

{{-- Default Content Wrapper --}}
<div class="{{ $layoutHelper->makeContentWrapperClasses() }}">

    {{-- Preloader Animation (cwrapper mode) --}}
    @if ($preloaderHelper->isPreloaderEnabled('cwrapper'))
        @include('partials.common.preloader')
    @endif

    {{-- Content Header --}}
    @hasSection('content_header')
        <div class="content-header">
            <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                @yield('content_header')
            </div>
        </div>
    @endif

    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <x-adminlte-card title="Edit Job Card" theme="success"  icon="fas fa-lg fa-person">
    
        <form action="{{ route('jobcardmanagement.update', $jobCard->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row pt-2">
                <x-adminlte-select name="client_id" id="client_id" fgroup-class="col-md-6" required>
                    <option value="">Select Client</option>
                    @foreach ($clients as $client)
                       <option value="{{ $client->id }}" {{ $client->id == $jobCard->client_id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-select name="estimate_id" id="estimate_id_span" fgroup-class="col-md-6" required>
                    <option value="">Select Estimate Number</option>
                    @foreach ($estimates as $estimate)
                       <option value="{{ $estimate->id }}" {{ $estimate->id == $jobCard->estimate_id ? 'selected' : '' }}>{{ $estimate->estimate_no }}</option>
                    @endforeach
                </x-adminlte-select>

                <x-adminlte-select name="handled_by" fgroup-class="col-md-6" required value="{{ old('handled_by') }}">
                    <option value="">Select Handled By</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $jobCard->handled_by ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-select name="informed_to" fgroup-class="col-md-6" required value="{{ old('informed_to') }}">
                    <option value="">Select Informed To</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $jobCard->informed_to ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </x-adminlte-select>
           
                <x-adminlte-textarea name="description" placeholder="Description" fgroup-class="col-md-6" >{{$jobCard->description}}</x-adminlte-textarea>
                <x-adminlte-select name="site_specific" fgroup-class="col-md-6" id="site_specific" required value="{{ old('site_specific', $jobCard->site_specific) }}">
                    <option value="">Select Site Specific</option>
                    <option value="1" {{ $jobCard->site_specific == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $jobCard->site_specific == '0' ? 'selected' : '' }}>No</option>
                </x-adminlte-select>
                <x-adminlte-input name="bill_no" placeholder="Bill Number" fgroup-class="col-md-6" value="{{ old('bill_no', $jobCard->bill_no) }}" />
                <x-adminlte-input name="protocol_no" placeholder="Protocol Number" fgroup-class="col-md-6" value="{{ old('protocol_no', $jobCard->protocol_no) }}" />
                <x-adminlte-input name="job_card_no" placeholder="Job Card Number" fgroup-class="col-md-6" value="{{ old('job_card_no', $jobCard->job_card_no) }}" label="Job Card Number"/>
                <x-adminlte-input name="date" placeholder="Date" fgroup-class="col-md-6" type='date' value="{{ old('date', $jobCard->date) }}" required label="Date"/>
                <x-adminlte-input name="invoice_date" placeholder="Invoice Date" fgroup-class="col-md-6" type='date' value="{{ old('invoice_date', $jobCard->invoice_date) }}" label="Invoice Date"/>
                <x-adminlte-input name="bill_date" placeholder="Bill Date" fgroup-class="col-md-6" type='date' value="{{ old('bill_date', $jobCard->bill_date) }}" label="Bill Date"/>
                <x-adminlte-input name="pd" placeholder="PD" fgroup-class="col-md-6" value="{{ old('pd', $jobCard->pd) }}" />
                <x-adminlte-input name="cr" placeholder="CR" fgroup-class="col-md-6" value="{{ old('cr', $jobCard->cr) }}" />
                <x-adminlte-input name="cn" placeholder="CN" fgroup-class="col-md-6" value="{{ old('cn', $jobCard->cn) }}" />
                <x-adminlte-input name="dv" placeholder="DV" fgroup-class="col-md-6" value="{{ old('dv', $jobCard->dv) }}" />
                <x-adminlte-input name="qc" placeholder="QC" fgroup-class="col-md-6" value="{{ old('qc', $jobCard->qc) }}" label="QC"/>
                <x-adminlte-input name="sent_date" placeholder="Sent Date" fgroup-class="col-md-6" type='date' value="{{ old('sent_date', $jobCard->sent_date) }}" required label="Sent Date" />

                <span id="site_specific_path" class="col-md-6">
                    @if($jobCard->site_specific == '1')
                        <div class="form-group col-md-12" style="padding: 0px;margin:0px">
                            <div class="input-group">
                                <input type="file" id="site_specific_path" name="site_specific_path" class="form-control" />
                            </div>
                        </div>
                    @endif
                </span>
            </div>
            
            <x-adminlte-button label="Update" type="submit" class="mt-3"/>
        </form>
        </x-adminlte-card>
    </div>

</div>

<script type="text/javascript">
    document.getElementById('site_specific').addEventListener('change', function() {
        if(this.value == 1 || this.value == '1'){
            document.getElementById('site_specific_path').innerHTML = '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><div class="input-group" ><input type="file" id="site_specific_path" name="site_specific_path" class="form-control" /></div></div>';
        } else {
            document.getElementById('site_specific_path').innerHTML = '';
        }
    });

    document.getElementById('client_id').addEventListener('change', function() {
        let client_id = this.value;
        $.ajax({
            url: "/job-card-management/client/" + client_id,
            method: 'GET',
            success: function(data) {
                $('#estimate_id_span').html(data.html);
            }
