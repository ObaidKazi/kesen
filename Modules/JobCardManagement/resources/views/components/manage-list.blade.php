@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        ['label' => '#'],
        ['label' => 'Document Name'],
        ['label' => 'Job No'],
        ['label' => 'Action'],
    ];

    $config = [
        'order' => [[1, 'asc']],
    ];
    $config['paging'] = true;
    $config['lengthMenu'] = [10, 50, 100, 500];

    $heads_manage = [
            ['label' => '#'],
            ['label' => 'Document Name'],
            ['label' => 'Job No'],
            ['label' => 'Language'],
            ['label' => 'Action'],
        ];

        $config_manage = [
            'order' => [[1, 'asc']],
        ];
        $config_manage['paging'] = true;
    @endphp

@if (!isset($list_estimate_language))
    
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
        <style>
            .page-item.active .page-link {
                background-color: #28a745 !important;
                border-color: #28a745 !important;
            }
        </style>
        <div class="content">
            @include('components.notification')

            <br><br>
            <div class="card" style="margin:10px">
                <div class="card-body">
            <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config" with-buttons>
                    @foreach ($job_register as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->estimate_document_id }}</td>
                            <td>{{ $row->sr_no }}</td>
                            <td>
                                <a href="{{ route('jobcardmanagement.manage.list', ['job_id' => $row->id, 'estimate_detail_id' => $row->estimate_document_id]) }}">
                                    <button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Manage">Manage</button>
                                </a>
                                <a href="{{ route('jobcardmanagement.pdf', ['job_id' => $row->id]) }}"  target="_blank">
                                    <button class="btn btn-xs btn-default text-dark mx-1 shadow" title="pdf">Preview</button>
                                </a>
                                <a href="{{ route('jobcardmanagement.bill', ['job_id' => $row->id]) }}">
                                    <button class="btn btn-xs btn-default text-dark mx-1 shadow" title="pdf">Bill</button>
                                </a>
                                @if($row->type=='site-specific')
                                    <a href="{{route('jobregistermanagement.excell', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                        Download Excel
                                    </button></a>
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
            </div>
        </div>
    </div>

@else

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
        <style>
            .page-item.active .page-link {
                background-color: #28a745 !important;
                border-color: #28a745 !important;
            }
        </style>
        <div class="content">
            @include('components.notification')

            <br><br>
            <div class="card" style="margin:10px">
                <div class="card-body">
            <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                <x-adminlte-datatable id="table8" :heads="$heads_manage" head-theme="dark" striped :config="$config_manage" with-buttons>
                    @foreach ($estimate_detail as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->document_name }}</td>
                            <td>{{ $detail->jobRegister->sr_no }}</td>
                            <td>{{ Modules\LanguageManagement\App\Models\Language::where('id', $detail->lang)->first()->name }}</td>
                            <td>
                                <a href="{{route('jobcardmanagement.manage.add', ['job_id' => $detail->jobRegister->id, 'estimate_detail_id' => $detail->id])}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">Edit</button></a>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
            </div>
        </div>
    </div>
@endif
