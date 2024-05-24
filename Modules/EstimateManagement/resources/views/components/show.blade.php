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
        <x-adminlte-card title="View Estimate" theme="success" icon="fas fa-lg fa-person">

            <form method="POST">
                @method('PUT')
                @csrf
                <div class="row pt-2">

                    <x-adminlte-input name="estimate_no" placeholder="Estimate Number" fgroup-class="col-md-6"
                        value="{{ $estimate->estimate_no }}" disabled label="Estimate Number" />
                    <x-adminlte-input name="client_id" placeholder="Client Name" fgroup-class="col-md-6"
                        value="{{ $estimate->client->name??'' }}" disabled label="Client Name" />
                    <x-adminlte-input name="client_contact_person_id" placeholder="Client Contact Person Name"
                        fgroup-class="col-md-6" value="{{ $estimate->client_person->name??'' }}" disabled
                        label="Client Contact Person Name" />
                    <x-adminlte-input name="headline" placeholder="Headline" fgroup-class="col-md-6" type='text'
                        value="{{ $estimate->headline }}" disabled label="Headline" />

                    <x-adminlte-input name="amount" placeholder="Amount" fgroup-class="col-md-6" type='text'
                        value="{{ $estimate->amount }}" disabled label="Amount" />

                    <x-adminlte-input name="currency" placeholder="Currency" fgroup-class="col-md-6" type='text'
                        value="{{ $estimate->currency }}" disabled label="Currency" />
                    <x-adminlte-select name="status" fgroup-class="col-md-6" disabled label="Status">
                        <option value="">Select Status</option>
                        <option value="0" @if ($estimate->status == '0') selected @endif>Pending</option>
                        <option value="1" @if ($estimate->status == '1') selected @endif>Approve</option>
                        <option value="2" @if ($estimate->status == '2') selected @endif>Reject</option>
                    </x-adminlte-select>


                    <x-adminlte-select name="metrix" fgroup-class="col-md-6" disabled label="Metrix">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $key => $value)
                            <option value="{{ $key }}" @if ($estimate->metrix == $key) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-input name="unit" placeholder="Unit" fgroup-class="col-md-6" type='text'
                        value="{{ $estimate->unit }}" disabled label="Unit" />
                    <x-adminlte-input name="rate" placeholder="Rate" fgroup-class="col-md-6" type='text'
                        value="{{ $estimate->rate }}" disabled label="Rate" />
                    <x-adminlte-input name="verification" placeholder="Verification" fgroup-class="col-md-6"
                        type='text' value="{{ $estimate->verification }}" disabled label="Verification" />
                    <x-adminlte-input name="bank_translation" placeholder="Bank Translation" fgroup-class="col-md-6"
                        type='text' value="{{ $estimate->bank_translation }}" disabled label="Bank Translation" />
                    <x-adminlte-input name="layout_charges" placeholder="Layout Charges" fgroup-class="col-md-6"
                        type='text' value="{{ $estimate->layout_charges }}" disabled label="Layout Charges" />
                    <x-adminlte-input name="layout_charges_2" placeholder="Layout Charges 2" fgroup-class="col-md-6"
                        type='text' value="{{ $estimate->layout_charges_2 }}" disabled label="Layout Charges 2" />
                    <x-adminlte-input name="lang" placeholder="Lang" fgroup-class="col-md-6" type='text'
                        value="{{ $estimate->lang }}" disabled label="Lang" />

                </div>
                   <x-adminlte-button label="Back" onclick="window.history.back();" class="mt-3"/>

            </form>
        </x-adminlte-card>
    </div>

</div>