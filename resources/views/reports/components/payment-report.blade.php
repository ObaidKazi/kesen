@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php 
    $writers = Modules\WriterManagement\App\Models\Writer::where('status', 1)->get(); 
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

    {{-- Main Content --}}
    <div class="content" style="padding-top: 20px; margin-left: 10px">
        <x-adminlte-card title="Payment Report" theme="success" icon="fas fa-lg fa-person">
            <form action="{{ route('report.payments') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select name="writer" fgroup-class="col-md-4" required value="{{ old('writer') }}"
                        label="Writer">
                        <option value="">Select Writer</option>
                        @foreach ($writers as $writer)
                            <option value="{{ $writer->id }}">{{ $writer->writer_name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-input name="from_date" placeholder="Date" fgroup-class="col-md-4" type='date'
                        value="{{ old('from_date', date('Y-m-d')) }}" required label="From Date" />

                    <x-adminlte-input name="to_date" placeholder="Date" fgroup-class="col-md-4" type='date'
                        value="{{ old('to_date', date('Y-m-d')) }}" required label="To Date" />
                   


                </div>
                
                <x-adminlte-button label="Submit" type="submit" class="mt-3" />
            </form>
        </x-adminlte-card>
    </div>
</div>