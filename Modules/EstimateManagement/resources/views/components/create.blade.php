@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php $metrics=config('services.metrix'); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp
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

    {{-- Main Content --}}
    
    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <x-adminlte-card title="New Estimate" theme="success"  icon="fas fa-lg fa-person"
    >
    
        <form action="{{ route('estimatemanagement.store') }}" method="POST" >
            @csrf
            <div class="row pt-2">
                <x-adminlte-input name="estimate_no"  placeholder="Estimate Number"
                    fgroup-class="col-md-6" required value="{{ old('estimate_no') }}"/>
                    <x-adminlte-select name="client_id" id="client_id" fgroup-class="col-md-6"  required >
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                               <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="client_contact_person_id" id="client_contact_person_id" fgroup-class="col-md-6"  required >
                        <option value="">Select Contact Person</option>
                    </x-adminlte-select>
                
                    <x-adminlte-input name="headline"  placeholder="Headline"
                    fgroup-class="col-md-6" type='text' value="{{ old('headline') }}" required/>

                    <x-adminlte-input name="amount"  placeholder="Amount"
                    fgroup-class="col-md-6" type='text' value="{{ old('amount') }}" required/>
                    
                    <x-adminlte-select name="currency"  placeholder="Currency" fgroup-class="col-md-6"  required >
                        <option value="">Select Currency</option>
                        {!! getCurrencyDropDown() !!}
                    </x-adminlte-select>
                    <x-adminlte-select name="status" fgroup-class="col-md-6"  required value="{{ old('status') }}">
                        <option value="">Select Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Approve</option>
                            <option value="2">Reject</option>
                    </x-adminlte-select>

                    
                    <x-adminlte-select name="metrix" fgroup-class="col-md-6"  required value="{{ old('metrix') }}">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-input name="unit"  placeholder="Unit"
                    fgroup-class="col-md-6" type='text' value="{{ old('unit') }}" required/>
                    <x-adminlte-input name="rate"  placeholder="Rate"
                    fgroup-class="col-md-6" type='text' value="{{ old('rate') }}" required/>
                    <x-adminlte-input name="verification"  placeholder="Verification"
                    fgroup-class="col-md-6" type='text' value="{{ old('verification') }}" required/>
                    <x-adminlte-input name="bank_translation"  placeholder="Bank Translation"
                    fgroup-class="col-md-6" type='text' value="{{ old('bank_translation') }}" required/>
                    <x-adminlte-input name="layout_charges"  placeholder="Layout Charges"
                    fgroup-class="col-md-6" type='text' value="{{ old('layout_charges') }}" required/>
                    <x-adminlte-input name="layout_charges_2"  placeholder="Layout Charges 2"
                    fgroup-class="col-md-6" type='text' value="{{ old('layout_charges_2')}}" required/>
                    <x-adminlte-input name="lang"  placeholder="Lang"
                    fgroup-class="col-md-6" type='text' value="{{ old('lang') }}" required/>


                    </span>
            </div>
            
            <x-adminlte-button label="Submit" type="submit" class="mt-3"/>

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
    </script>
