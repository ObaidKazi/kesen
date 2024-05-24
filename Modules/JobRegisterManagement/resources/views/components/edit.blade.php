
@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
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
    $config = [
        "title" => "Select Estimate Number",
        "liveSearch" => true,
        "placeholder" => "Search Estimate Number...",
        "showTick" => true,
        "actionsBox" => true
    ]
@endphp
@php
    $config_language = [
        "placeholder" => "Search Language...",
        "allowClear" => true,
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
        <x-adminlte-card title="Edit Job Register" theme="success" icon="fas fa-lg fa-person">
            <form action="{{ route('jobregistermanagement.update', $jobRegister->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row pt-2">
                    <x-adminlte-select name="client_id" id="client_id" fgroup-class="col-md-6" required label="Client"> 
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ $jobRegister->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="client_contact_person_id" id="client_contact_person_id" fgroup-class="col-md-6" required label="Contact Person">
                        <option value="">Select Contact Person</option>
                        <!-- Populate this dynamically based on selected client -->
                    </x-adminlte-select>
                    <x-adminlte-select2 name="estimate_id" fgroup-class="col-md-6" required :config="$config" label="Estimate Number">
                        <option value="">Select Estimate</option>
                        @foreach ($estimates as $estimate)
                            <option value="{{ $estimate->id }}" {{ $jobRegister->estimate_id == $estimate->id ? 'selected' : '' }}>{{ $estimate->estimate_no }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select name="metrix" fgroup-class="col-md-6" required label="Metrix">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $key => $value)
                            <option value="{{ $key }}" {{ $jobRegister->metrix == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-select name="handled_by_id" fgroup-class="col-md-6" required label="Handled By">
                        <option value="">Select Handled By</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $jobRegister->handled_by_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-select name="client_accountant_person_id" fgroup-class="col-md-6" required label="Accountant">
                        <option value="">Select Accountant</option>
                        @foreach ($accountants as $user)
                            <option value="{{ $user->id }}" {{ $jobRegister->client_accountant_person_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-textarea name="other_details" placeholder="Other Details" fgroup-class="col-md-6" label="Other Details">{{ $jobRegister->other_details }}</x-adminlte-textarea>

                    <x-adminlte-select name="type" fgroup-class="col-md-6" id="type" required label="Job Type">
                        <option value="">Job Type</option>
                        <option value="1" {{ $jobRegister->type == 1 ? 'selected' : '' }}>Protocol</option>
                        <option value="2" {{ $jobRegister->type == 2 ? 'selected' : '' }}>Non-Protocol / Advertising - Consolidate CON</option>
                    </x-adminlte-select>
                    <span class="col-md-6">
                        <label for="language">
                            Select Language
                        </label>
                        <select class="selectpicker" name="language[]" multiple data-live-search="true">
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}" {{ in_array($language->id, $jobRegister->language_id) ? 'selected' : '' }}>
                                    {{ $language->name }}
                                </option>
                            @endforeach
                        </select>
                    </span>
                    
                    

                    <x-adminlte-input name="protocol_no" placeholder="Protocol Number" fgroup-class="col-md-6" value="{{ $jobRegister->protocol_no }}" label="Protocol Number"/>

                    <x-adminlte-input name="date" placeholder="Date" fgroup-class="col-md-6" type="date" value="{{ $jobRegister->date }}" required label="Date"/>

                    <x-adminlte-textarea name="description" placeholder="HEADING / DESCRIPTION" fgroup-class="col-md-6" label="HEADING / DESCRIPTION">{{ $jobRegister->description }}</x-adminlte-textarea>

                    <x-adminlte-select name="status" fgroup-class="col-md-6" required label="Status">
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
                                    <textarea id="cancel_reason" name="cancel_reason" class="form-control" placeholder="Cancel Reason">{{ $jobRegister->cancel_reason }}</textarea>
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
    document.getElementById('client_id').addEventListener('change', function() {
        let client_id = this.value;
        console.log(client_id);
        $.ajax({
            url: "/estimate-management/client/"+client_id,
            method: 'GET',
            success: function(data) {
                $('#client_contact_person_id').html(data.html);
            }
        });
    });
    document.getElementById('client_id').dispatchEvent(new Event('change'));
    document.getElementById('status').addEventListener('change', function() {
        if(this.value == 2 || this.value == '2'){
            document.getElementById('cancel').innerHTML = '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><div class="input-group"><textarea id="cancel_reason" name="cancel_reason" class="form-control" placeholder="Cancel Reason"></textarea></div></div>';
        }else{
            document.getElementById('cancel').innerHTML = '';
        }
    });
</script>
