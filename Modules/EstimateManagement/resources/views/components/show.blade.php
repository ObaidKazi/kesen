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
        <x-adminlte-card title="View Estimate" theme="success"  icon="fas fa-lg fa-person"
    >
    
        <form  method="POST" >
            @method('PUT')
            @csrf
            <div class="row pt-2">
                
                    <x-adminlte-input name="estimate_no"  placeholder="Estimate Number"
                    fgroup-class="col-md-6"  value="{{ $estimate->estimate_no }}" disabled/>
                <x-adminlte-input name="client_id"  placeholder="Client Name"
                    fgroup-class="col-md-6" value="{{ $estimate->client_id }}" disabled/>
                    <x-adminlte-input name="client_contact_person_id"  placeholder="Client Contact Person Name"
                    fgroup-class="col-md-6" value="{{ $estimate->client_contact_person_id }}" disabled/>
                    <x-adminlte-input name="headline"  placeholder="Headline"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->headline }}" disabled/>

                    <x-adminlte-input name="amount"  placeholder="Amount"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->amount }}" disabled/>
                    
                    <x-adminlte-input name="currency"  placeholder="Currency"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->currency }}" disabled/> 
                    <x-adminlte-select name="status" fgroup-class="col-md-6"  disabled >
                        <option value="">Select Status</option>
                            <option value="0" @if ($estimate->status == '0') selected @endif>Pending</option>
                            <option value="1" @if ($estimate->status == '1') selected @endif>Approve</option>
                            <option value="2" @if ($estimate->status == '2') selected @endif>Reject</option>
                    </x-adminlte-select>

                    
                    <x-adminlte-select name="metrix" fgroup-class="col-md-6"  disabled>
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $key => $value)
                            <option value="{{ $key }}" @if ($estimate->metrix == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-input name="unit"  placeholder="Unit"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->unit }}" disabled/>
                    <x-adminlte-input name="rate"  placeholder="Rate"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->rate }}" disabled/>
                    <x-adminlte-input name="verification"  placeholder="Verification"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->verification }}" disabled/>
                    <x-adminlte-input name="bank_translation"  placeholder="Bank Translation"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->bank_translation }}" disabled/>
                    <x-adminlte-input name="layout_charges"  placeholder="Layout Charges"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->layout_charges }}" disabled/>
                    <x-adminlte-input name="layout_charges_2"  placeholder="Layout Charges 2"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->layout_charges_2 }}" disabled/>
                    <x-adminlte-input name="lang"  placeholder="Lang"
                    fgroup-class="col-md-6" type='text' value="{{ $estimate->lang }}" disabled/>

                    </span>
            </div>
            
            
        </form>
        </x-adminlte-card>
    </div>

</div>
