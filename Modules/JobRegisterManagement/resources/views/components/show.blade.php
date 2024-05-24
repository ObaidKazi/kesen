
@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@section('plugins.Select2', true)
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp
@php $estimates=Modules\EstimateManagement\App\Models\Estimates::where('status',1)->get(); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp
@php $users=App\Models\User::where('email','!=','developer@kesen.com')->where('id','!=',Auth()->user()->id)->whereDoesntHave('roles', function($query) {
    $query->where('name','Accounts');
})->get(); @endphp
@php $accountants=App\Models\User::where('email','!=','developer@kesen.com')->where('id','!=',Auth()->user()->id)->whereHas('roles', function($query) {
    $query->where('name','Accounts');
})->get(); @endphp
@php $metrics=config('services.metrix'); @endphp
@php
    $contact_person=Modules\ClientManagement\App\Models\ContactPerson::where('id',$jobRegister->client_contact_person_id)->first()->name;
@endphp

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
        <x-adminlte-card title="Show Job Register" theme="success" icon="fas fa-lg fa-person">
            <form>
                <div class="row pt-2">
                    <x-adminlte-select name="client_id" id="client_id" fgroup-class="col-md-6" disabled label="Client">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ $jobRegister->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-input name="client_contact_person_id" placeholder="Client Contact Person" fgroup-class="col-md-6" value={{$contact_person}} disabled label="Contact Person"/>
                    
                    
                    <x-adminlte-select2 name="estimate_id" fgroup-class="col-md-6" disabled :config="$config" label="Estimate Number">
                        <option value="">Select Estimate</option>
                        @foreach ($estimates as $estimate)
                            <option value="{{ $estimate->id }}" {{ $jobRegister->estimate_id == $estimate->id ? 'selected' : '' }} >{{ $estimate->estimate_no }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select name="metrix" fgroup-class="col-md-6" disabled label="Metrix">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $key => $value)
                            <option value="{{ $key }}" {{ $jobRegister->metrix == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-select name="handled_by_id" fgroup-class="col-md-6" disabled label="Handled By">
                        <option value="">Select Handled By</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $jobRegister->handled_by_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-select name="client_accountant_person_id" fgroup-class="col-md-6" disabled label="Accountant">
                        <option value="">Select Accountant</option>
                        @foreach ($accountants as $user)
                            <option value="{{ $user->id }}" {{ $jobRegister->client_accountant_person_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-textarea name="other_details" placeholder="Other Details" fgroup-class="col-md-6" disabled label="Other Details">{{ $jobRegister->other_details }}</x-adminlte-textarea>

                    <x-adminlte-select name="type" fgroup-class="col-md-6" id="type" disabled label="Job Type">
                        <option value="">Job Type</option>
                        <option value="1" {{ $jobRegister->type == 1 ? 'selected' : '' }}>Protocol</option>
                        <option value="2" {{ $jobRegister->type == 2 ? 'selected' : '' }}>Non-Protocol / Advertising - Consolidate CON</option>
                    </x-adminlte-select>

                    <x-adminlte-select name="language" fgroup-class="col-md-6" disabled label="Language">
                        <option value="">Select Language</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}" {{ $jobRegister->language_id == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-input name="protocol_no" placeholder="Protocol Number" fgroup-class="col-md-6" value="{{ $jobRegister->protocol_no }}" disabled label="Protocol Number"/>

                    <x-adminlte-input name="date" placeholder="Date" fgroup-class="col-md-6" type="date" value="{{ $jobRegister->date }}" disabled label="Date"/>

                    <x-adminlte-textarea name="description" placeholder="HEADING / DESCRIPTION" fgroup-class="col-md-6" disabled label="HEADING / DESCRIPTION">{{ $jobRegister->description }}</x-adminlte-textarea>

                    <x-adminlte-select name="status" fgroup-class="col-md-6" disabled label="Status">
                        <option value="">Select Status</option>
                        <option value="0" {{ $jobRegister->status == 0 ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ $jobRegister->status == 1 ? 'selected' : '' }}>Approve</option>
                        <option value="2" {{ $jobRegister->status == 2 ? 'selected' : '' }}>Cancel</option>
                    </x-adminlte-select>

                    <span id="cancel" class="col-md-6">
                        <label for="language">
                            Cancel Reason
                        </label>
                        @if($jobRegister->status == 2)
                            <div class="form-group col-md-12" style="padding: 0px;margin:0px">
                                <div class="input-group">
                                    <textarea id="cancel_reason" name="cancel_reason" class="form-control" placeholder="Cancel Reason" disabled>{{ $jobRegister->cancel_reason }}</textarea>
                                </div>
                            </div>
                        @endif
                    </span>
                </div>

                <a href="{{ route('jobregistermanagement.index') }}" class="btn btn-default mt-3">Back</a>
            </form>
        </x-adminlte-card>
    </div>
</div>
