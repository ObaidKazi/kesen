@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp
@php $estimates=Modules\EstimateManagement\App\Models\Estimates::where('status',1)->get(); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp
@php $contact_persons=Modules\ClientManagement\App\Models\ContactPerson::where('status',1)->get(); @endphp
@php
    $users = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Accounts');
        })
        ->get();
@endphp
@php
    $accountants = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->whereHas('roles', function ($query) {
            $query->where('name', 'Accounts');
        })
        ->get();
@endphp
@php $metrics=App\Models\Metrix::get(); @endphp
@php
    $config = [
        'title' => 'Select Estimate Number',
        'liveSearch' => true,
        'placeholder' => 'Search Estimate Number...',
        'showTick' => true,
        'actionsBox' => true,
    ];
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
        <x-adminlte-card title="New Job Register" theme="success" icon="fas fa-lg fa-person">

            <form action="{{ route('jobregistermanagement.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select name="metrix" fgroup-class="col-md-6" required value="{{ old('metrix') }}"
                        label="Metrix">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $metric)
                            <option value="{{ $metric->id }}">{{ $metric->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select2 name="estimate_id" fgroup-class="col-md-6" required :config="$config"
                        label="Estimate Number" id="estimate_number">
                        <option value="">Select Estimate</option>
                        @foreach ($estimates as $estimate)
                            <option value="{{ $estimate->id }}">{{ $estimate->estimate_no }}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select name="client_id" id="client_id" fgroup-class="col-md-6" required label="Client">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    
                    <x-adminlte-select name="client_contact_person_id" id="client_contact_person_id"
                        fgroup-class="col-md-6" required label="Contact Person">
                        <option value="">Select Contact Person</option>
                        @foreach ($contact_persons as $contact)
                            <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="estimate_document_id" id="estimate_document_id" fgroup-class="col-md-6"  required label="Estimate Document">
                        <option value="">Select Estimate Document</option>
                    </x-adminlte-select>
                    

                    <x-adminlte-select name="handled_by_id" fgroup-class="col-md-6" required
                        value="{{ old('handled_by_id') }}" label="Handled By">
                        <option value="">Select Handled By</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-select name="client_accountant_person_id" fgroup-class="col-md-6" required
                        value="{{ old('client_accountant_person_id') }}" label="Accountant">
                        <option value="">Select Accountant</option>
                        @foreach ($accountants as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-textarea name="other_details" placeholder="Other Details" fgroup-class="col-md-6"
                        value="{{ old('other_details') }}" label="Other Details" />
                    <x-adminlte-select name="category" fgroup-class="col-md-6" id="category" required
                        value="{{ old('category') }}" label="Category">
                        <option value="">Category</option>
                        <option value="1">Protocol</option>
                        <option value="2">Non-Protocol / Advertising - Consolidate CON</option>
                    </x-adminlte-select>
                    <span id="type" class="col-md-6" style="display: none;">

                    </span>
                    <x-adminlte-select name="informed_to" fgroup-class="col-md-6"  required value="{{ old('informed_to') }}" label="Infomed To">
                        <option value="">Select Informed To</option>
                        @foreach ($users as  $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    
                    <x-adminlte-input name="protocol_no" placeholder="Protocol Number" fgroup-class="col-md-6"
                        value="{{ old('protocol_no') }}" label="Protocol Number" />
                    <x-adminlte-input name="date" placeholder="Date" fgroup-class="col-md-6" type='date'
                        value="{{ old('date', date('Y-m-d')) }}" required label="Date" min="{{ getCurrentDate() }}"/>
                    <x-adminlte-textarea name="description" placeholder="HEADING / DESCRIPTION" fgroup-class="col-md-6"
                        value="{{ old('description') }}" label="HEADING / DESCRIPTION" />
                    
                        <x-adminlte-input name="bill_no"  placeholder="Bill Number"
                    fgroup-class="col-md-6" value="{{ old('bill_no') }}"  label="Bill Number"/>
                    <x-adminlte-input name="invoice_date"  placeholder="Invoice Date"
                    fgroup-class="col-md-6" type='date' value="{{ old('invoice_date',getCurrentDate()) }}" label="Invoice Date" min="{{ getCurrentDate() }}"/>
                    <x-adminlte-input name="bill_date"  placeholder="Bill Date"
                    fgroup-class="col-md-6" type='date' value="{{ old('bill_date',getCurrentDate()) }}" label="Bill Date" min="{{ getCurrentDate() }}"/>
                    
                    <x-adminlte-input name="sent_date"  placeholder="Date"
                    fgroup-class="col-md-6" type='date' value="{{ old('sent_date',getCurrentDate()) }}" required label="Sent Date" min="{{ getCurrentDate() }}"/>
                    <x-adminlte-select name="site_specific" fgroup-class="col-md-6" id="site_specific" required value="{{ old('site_specific') }}" label="Site Specific">
                        <option value="">Select Site Specific</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </x-adminlte-select>
                    <x-adminlte-select name="status" fgroup-class="col-md-6" required value="{{ old('status') }}"
                        label="Status">
                        <option value="">Select Status</option>
                        <option value="0" selected>Pending</option>
                        <option value="1">Approve</option>
                        <option value="2">Cancel</option>
                    </x-adminlte-select>
                    <span id="site_specific_path" class="col-md-6">

                    </span>
                    

                    <span id="cancel" class="col-md-6">

                    </span>
                </div>

                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
<script type="text/javascript">
    
    document.getElementById('site_specific').addEventListener('change', function() {
    if(this.value == 1||this.value == '1'){
        document.getElementById('site_specific_path').innerHTML = '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="language">Site Specific File</label><br><div class="input-group" ><input type="file" id="site_specific_path" name="site_specific_path" class="form-control" /></div></div>';
    }else{
        document.getElementById('site_specific_path').innerHTML = '';
    }
});

    $(document).ready(function() {
        $('#estimate_number').on('change', function() {
            $.ajax({
                url: "/estimate-management/estimate/" + $('#estimate_number').val(),
                method: 'GET',
                success: function(data) {
                    if (data != false) {
                        document.getElementById("client_contact_person_id").value = data
                            .client_contact_person_id;
                        document.getElementById("client_id").value = data.client_id;
                    }
                }
            });
            $.ajax({
            url: "/estimate-management/estimate-details/"+ $('#estimate_number').val(),
            method: 'GET',
            success: function(data) {
                $('#estimate_document_id').html(data.html);
            }
        });
        });
        $('#category').on('change', function() {
            
            if ($('#category').val() == 2 || $('#category').val() == '2') {
                console.log($('#category').val());
                $('#type').css("display", "block");
                document.getElementById('type').innerHTML =
                    '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="language">Job Type</label><br><div class="input-group"><select class="form-control"><option value="">Job Type</option><option value="new">New</option><option value="amendment">Amendment</option><option value="site-specific">Site Specific</option></select></div></div>';
            } else {
                document.getElementById('type').display = "none";
            }
        });

    })
    document.getElementById('status').addEventListener('change', function() {
        if (this.value == 2 || this.value == '2') {
            document.getElementById('cancel').innerHTML =
                '<div class="form-group col-md-12" style="padding: 0px;margin:0px"><label for="language">Cancel Reason</label><br><div class="input-group"><textarea id="cancel_reason" name="cancel_reason" class="form-control" placeholder="Cancel Reason"></textarea></div></div>';
        } else {
            document.getElementById('cancel').innerHTML = '';
        }

    });
    document.getElementById('category').addEventListener('change', function() {

    });
</script>
