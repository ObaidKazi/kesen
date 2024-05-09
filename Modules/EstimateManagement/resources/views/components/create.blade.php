@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php $metrics=config('services.metrix'); @endphp
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
        <x-adminlte-card title="New Employee" theme="success"  icon="fas fa-lg fa-person"
    >
    
        <form action="{{ route('estimatemanagement.store') }}" method="POST" >
            @csrf
            <div class="row pt-2">
                <x-adminlte-input name="estimate_no"  placeholder="Estimate Number"
                    fgroup-class="col-md-6" required value="{{ old('estimate_no') }}"/>
                <x-adminlte-input name="client_name"  placeholder="Client Name"
                    fgroup-class="col-md-6" value="{{ old('client_name') }}"/>
                    <x-adminlte-input name="client_contact_person_name"  placeholder="Client Contact Person Name"
                    fgroup-class="col-md-6" value="{{ old('client_contact_person_name') }}"/>
                    <x-adminlte-input name="headline"  placeholder="Headline"
                    fgroup-class="col-md-6" type='text' value="{{ old('headline') }}" required/>

                    <x-adminlte-input name="amount"  placeholder="Amount"
                    fgroup-class="col-md-6" type='text' value="{{ old('amount') }}" required/>
                    
                    <x-adminlte-input name="currency"  placeholder="Currency"
                    fgroup-class="col-md-6" type='text' value="{{ old('currency') }}" required/> 
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

                    </span>
            </div>
            
            <x-adminlte-button label="Submit" type="submit" class="mt-3"/>

        </form>
        </x-adminlte-card>
    </div>

</div>
