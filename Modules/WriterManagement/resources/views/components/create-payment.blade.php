@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
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
        <x-adminlte-card title="New Payment" theme="success">
            <form action="{{ route('writermanagement.addPayment',$id) }}" method="POST">
                @method('POST')
                @csrf
                <div class="row pt-2">
                    
                    <x-adminlte-input name="payment_method" placeholder="Payment Method" fgroup-class="col-md-6" required value="{{ old('payment_method') }}"/>
                    <x-adminlte-select name="metrix"  fgroup-class="col-md-6"  required value="{{ old('metrix') }}">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>
    
                    <x-adminlte-select name="apply_gst" placeholder="Apply GST" fgroup-class="col-md-6" required>
                        <option value="">Apply GST</option>
                        <option value="0" {{ old('apply_gst','') == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('apply_gst','') == 1 ? 'selected' : '' }}>Yes</option>
                    </x-adminlte-select>
                    <x-adminlte-select name="apply_tds" placeholder="Apply TDS" fgroup-class="col-md-6" required>
                        <option value="">Apply TDS</option>
                        <option value="0" {{ old('apply_tds','') == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('apply_tds','') == 1 ? 'selected' : '' }}>Yes</option>
                    </x-adminlte-select>
                    <x-adminlte-input name="period_from" placeholder="Period From" fgroup-class="col-md-6" type="date" required value="{{ old('period_from') }}"/>
                    <x-adminlte-input name="period_to" placeholder="Period To" fgroup-class="col-md-6" type="date" required value="{{ old('period_to') }}"/>
                    <x-adminlte-input name="online_ref_no" placeholder="Online REF no" fgroup-class="col-md-6" value="{{ old('online_ref_no') }}"/>
                    <x-adminlte-input name="cheque_no" placeholder="Cheque no" fgroup-class="col-md-6" value="{{ old('cheque_no') }}"/>
                    <x-adminlte-input name="performance_charge" placeholder="Performance Charge" fgroup-class="col-md-6" type="number" step="0.01" required value="{{ old('performance_charge') }}"/>
                    <x-adminlte-input name="deductible" placeholder="Deductible" fgroup-class="col-md-6" type="number" step="0.01" required value="{{ old('deductible') }}"/>
                    <x-adminlte-input name="writer_id"  fgroup-class="col-md-6" required value="{{$id}}" hidden/>
                </div>
                <x-adminlte-button label="Submit" type="submit" class="mt-3"/>
            </form>
        </x-adminlte-card>
    </div>
</div>
