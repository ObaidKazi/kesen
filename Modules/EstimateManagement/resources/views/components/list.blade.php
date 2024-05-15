@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@php
    $heads = [
        [
            'label' => 'ID',
        ],
        [
            'label' => 'Estimate No',
        ],
        [
            'label' => 'Client Name',
        ],
        [
            'label' => 'Contact Person Name',
        ],
        [
            'label' => 'Metrix',
        ],

        [
            'label' => 'Headline',
        ],
        [
            'label' => 'Amount',
        ],

        [
            'label' => 'Currency',
        ],
        [
            'label' => 'Status',
        ],
        [
            'label' => 'Created At',
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
        <a href="{{ route('estimatemanagement.create') }}"><button class="btn btn-md btn-success "
                style="float:right;margin:10px">Add Estimate</button></a>
        <br>
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
            <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
                with-buttons>
                @foreach ($estimates as $index=>$row)
                
                    <tr>

                        <td>{{ $index+1 }}</td>
                        <td>{{ $row->estimate_no }}</td>
                        <td>{{ Modules\ClientManagement\App\Models\Client::where('id',$row->client_id)->first()->name??'';}}</td>
                        <td>{{  Modules\ClientManagement\App\Models\ContactPerson::where('id',$row->client_contact_person_id)->first()->name??'';}}</td>
                        <td>{{ $row->metrix }}</td>
                        <td>{{ $row->headline }}</td>
                        <td>{{ $row->amount }}</td>
                        <td>{{ $row->currency }}</td>
                        <td>{{ $row->status == 0 ? 'Pending' : ($row->status == 1 ? 'Approved' : 'Rejected');}}</td>
                        <td>{{ $row->created_at }}</td>
                        <td>
                            <a href="{{route('estimatemanagement.edit', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                               Edit
                            </button></a>
                            
                            <a href="{{route('estimatemanagement.show', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="View">
                                View
                            </button></a>
                            <a href="{{route('estimatemanagement.viewPdf', $row->id)}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="View">
                                Export
                            </button></a>
                            
                      
                        </td>

                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

</div>
