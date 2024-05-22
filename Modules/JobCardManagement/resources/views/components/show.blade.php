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
        <x-adminlte-card title="View Job Card" theme="success"  icon="fas fa-lg fa-eye">
    
        <form>
            <div class="row pt-2">
                <x-adminlte-select name="client_id" id="client_id" fgroup-class="col-md-6" disabled label="Client">
                    <option value="">Select Client</option>
                    @foreach ($clients as $client)
                       <option value="{{ $client->id }}" {{ $client->id == $jobCard->client_id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-select name="estimate_id" id="estimate_id_span" fgroup-class="col-md-6" disabled label="Estimate Number">
                    <option value="">Select Estimate Number</option>
                    @foreach ($estimates as $estimate)
                       <option value="{{ $estimate->id }}" {{ $estimate->id == $jobCard->estimate_id ? 'selected' : '' }}>{{ $estimate->estimate_no }}</option>
                    @endforeach
                </x-adminlte-select>

                <x-adminlte-select name="handled_by" fgroup-class="col-md-6" disabled value="{{ old('handled_by') }}" label="Handle By">
                    <option value="">Select Handled By</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $jobCard->handled_by ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-select name="informed_to" fgroup-class="col-md-6" disabled value="{{ old('informed_to') }}" label="Infomed To">
                    <option value="">Select Informed To</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $jobCard->informed_to ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </x-adminlte-select>
           
                <x-adminlte-textarea name="description" placeholder="Description" fgroup-class="col-md-6" disabled label="Description">{{$jobCard->description}}</x-adminlte-textarea>
                <x-adminlte-select name="site_specific" fgroup-class="col-md-6" id="site_specific" disabled value="{{ old('site_specific', $jobCard->site_specific) }}" label="Site Specific">
                    <option value="">Select Site Specific</option>
                    <option value="1" {{ $jobCard->site_specific == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $jobCard->site_specific == '0' ? 'selected' : '' }}>No</option>
                </x-adminlte-select>
                <x-adminlte-input name="bill_no" placeholder="Bill Number" fgroup-class="col-md-6" value="{{ old('bill_no', $jobCard->bill_no) }}" disabled label="Bill Number"/>
                <x-adminlte-input name="protocol_no" placeholder="Protocol Number" fgroup-class="col-md-6" value="{{ old('protocol_no', $jobCard->protocol_no) }}" disabled  label="Protocol Number"/>
                <x-adminlte-input name="job_card_no" placeholder="Job Card Number" fgroup-class="col-md-6" value="{{ old('job_card_no', $jobCard->job_card_no) }}" disabled label="Job Card Number"/>
                <x-adminlte-input name="date" placeholder="Date" fgroup-class="col-md-6" type='date' value="{{ old('date', $jobCard->date) }}" disabled label="Date"/>
                <x-adminlte-input name="invoice_date" placeholder="Invoice Date" fgroup-class="col-md-6" type='date' value="{{ old('invoice_date', $jobCard->invoice_date) }}" disabled label="Invoice Date"/>
                <x-adminlte-input name="bill_date" placeholder="Bill Date" fgroup-class="col-md-6" type='date' value="{{ old('bill_date', $jobCard->bill_date) }}" disabled label="Bill Date"/>
                <x-adminlte-input name="pd" placeholder="PD" fgroup-class="col-md-6" value="{{ old('pd', $jobCard->pd) }}" disabled label="PD"/>
                <x-adminlte-input name="cr" placeholder="CR" fgroup-class="col-md-6" value="{{ old('cr', $jobCard->cr) }}" disabled label="CR"/>
                <x-adminlte-input name="cn" placeholder="CN" fgroup-class="col-md-6" value="{{ old('cn', $jobCard->cn) }}" disabled label="CN"/>
                <x-adminlte-input name="dv" placeholder="DV" fgroup-class="col-md-6" value="{{ old('dv', $jobCard->dv) }}" disabled label="DV"/>
                <x-adminlte-input name="qc" placeholder="QC" fgroup-class="col-md-6" value="{{ old('qc', $jobCard->qc) }}" disabled label="QC"/>
                <x-adminlte-input name="sent_date" placeholder="Sent Date" fgroup-class="col-md-6" type='date' value="{{ old('sent_date', $jobCard->sent_date) }}" disabled label="Sent Date"/>

                <span id="site_specific_path" class="col-md-6">
                    @if($jobCard->site_specific == '1')
                        <div class="form-group col-md-12" style="padding: 0px;margin:0px">
                            <div class="input-group">
                                <input type="file" id="site_specific_path" name="site_specific_path" class="form-control" disabled />
                            </div>
                        </div>
                    @endif
                </span>
            </div>
            
            <x-adminlte-button label="Back" onclick="window.history.back();" class="mt-3"/>
        </form>
        </x-adminlte-card>
    </div>

</div>
