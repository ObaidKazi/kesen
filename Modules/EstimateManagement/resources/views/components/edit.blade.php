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
        <x-adminlte-card title="Edit Estimate" theme="success"  icon="fas fa-lg fa-person"
    >
    
        <form action="{{ route('estimatemanagement.update', $estimate->id) }}" method="POST" >
            @method('PUT')
            @csrf
            <div class="row pt-2">
                
                    <x-adminlte-input name="estimate_no"  placeholder="Estimate Number"
                    fgroup-class="col-md-6" required value="{{ $estimate->estimate_no }}"/>
                <x-adminlte-input name="client_name"  placeholder="Client Name"
                    fgroup-class="col-md-6" value="{{ $estimate->client_name }}"/>
                    <x-adminlte-input name="client_contact_person_name"  placeholder="Client Contact Person Name"
                    fgroup-class="col-md-6" value="{{ $estimate->client_contact_person_name }}"/>
                    <x-adminlte-input name="headline"  placeholder="Headline"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->headline }}" required/>

                    <x-adminlte-input name="amount"  placeholder="Amount"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->amount }}" required/>
                    
                    <x-adminlte-input name="currency"  placeholder="Currency"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->currency }}" required/> 
                    <x-adminlte-select name="status" fgroup-class="col-md-6"  required >
                        <option value="">Select Status</option>
                            <option value="0" @if ($estimate->status == '0') selected @endif>Pending</option>
                            <option value="1" @if ($estimate->status == '1') selected @endif>Approve</option>
                            <option value="2" @if ($estimate->status == '2') selected @endif>Reject</option>
                    </x-adminlte-select>

                    
                    <x-adminlte-select name="metrix" fgroup-class="col-md-6"  required >
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $key => $value)
                            <option value="{{ $key }}" @if ($estimate->metrix == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>

                    </span>
            </div>
            
            <x-adminlte-button label="Submit" type="submit" class="mt-3"/>
        </form>
        </x-adminlte-card>
    </div>

</div>
