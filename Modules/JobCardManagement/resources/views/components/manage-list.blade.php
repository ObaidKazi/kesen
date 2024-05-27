@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        [
            'label' => '#',
        ],
        [
            'label' => 'Document Name',
        ],
        [
            'label' => 'Job No',
        ],
        [
            'label' => 'Language',
        ],   

        [
            'label' => 'Action',
        ],   
    ];

    

    $config = [
        'order' => [[1, 'desc']],
    ];
    $config['paging'] = true;
    $config['lengthMenu'] = [10, 50, 100, 500];
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
    <style>

        .page-item.active .page-link {
                    background-color: #28a745!important; /* Change active page background color as needed */
                    border-color: #28a745!important; /* Change active page border color as needed */
                }
        </style>
    <div class="content">
        @include('components.notification')
        <a href="{{ route('jobcardmanagement.create') }}"><button class="btn btn-md btn-success "
                style="float:right;margin:10px">Add Job Card</button></a>
        <br>
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
            <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
                with-buttons>
                @foreach ($estimate_details as $index=>$row)
                
                    <tr>

                        <td>{{ $index+1 }}</td>
                        <td>{{$row->document_name}}</td>
                        <td>{{ $job_register->sr_no}}</td>
                        <td>{{  $row->lang}}</td>
                        <td>
                            <a href="{{route('jobcardmanagement.manage.add', ['job_id' => $job_register->id, 'estimate_detail_id' => $row->id])}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                              Edit
                            </button></a>

                        </td>

                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

</div>
