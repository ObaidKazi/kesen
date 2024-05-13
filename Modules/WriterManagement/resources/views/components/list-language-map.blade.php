@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@php
    $heads = [
        [
            'label' => 'Sr. No.',
        ],
        [
            'label' => 'Language Name',
        ],
        [
            'label' => 'Per Unit Charges',
        ],
        [
            'label' => 'Checking Charges',
        ],
        [
            'label' => 'Bt Charges',
        ],

        [
            'label' => 'Bt Checking Charges',
        ],
        [
            'label' => 'Advertising Charges',
        ],
        
        [
            'label' => 'Action',
        ],
    ];

    

    $config = [
        'order' => [[1, 'asc']],
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
        <div class="content-header" >
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
        <div class="content" style="padding-top: 20px;margin-left: 10px">
            @if(Session::has('message'))
        <x-adminlte-alert theme="success" title="Success" dismissable>
            {{ Session::get('message') }}
        </x-adminlte-alert>
        @endif
        @if(Session::has('alert'))
        <x-adminlte-alert theme="danger" title="Danger" dismissable>
            {{ Session::get('message') }}
        </x-adminlte-alert>
        @endif
        <a href="{{ route('writermanagement.addLanguageMapView',$id) }}"><button class="btn btn-md btn-success "
                style="float:right;margin:10px">Add Language Map</button></a>
        <br>
        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
            <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" striped :config="$config"
                with-buttons>
                @foreach ($language_map as $index=>$row)
                
                    <tr>

                        <td>{{ $index+1 }}</td>
                        <td>{{ $row->language_id }}</td>
                        <td>{{ $row->per_unit_charges }}</td>
                        <td>{{ $row->checking_charges }}</td>
                        <td>{{ $row->bt_charges }}</td>
                        <td>{{ $row->bt_checking_charges }}</td>
                        <td>{{ $row->advertising_charges }}</td>
                        <td>
                            <a href="{{route('writermanagement.editLanguageMap',[$id,$row->id])}}"><button class="btn btn-xs btn-default text-dark mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button></a>
                            <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" onclick="deleteLanguageMap('{{route('writermanagement.deleteLanguageMap',[$id,$row->id])}}')">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                      </button>
                        </td>

                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>

</div>

<script>
    function deleteLanguageMap(url){
        Swal.fire({
        title: "Are you sure?",
        showCancelButton: true,
        confirmButtonText: "Yes",
        }).then((result) => {
        
        if (result.value) {
            window.open(url,"_self")
        } else if (result.isDenied) {
            return false;
        }
    });
    }
</script>