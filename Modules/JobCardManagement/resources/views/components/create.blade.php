@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@section('plugins.Select2', true)

@php
    $users = App\Models\User::where('email', '!=', 'developer@kesen.com')
        ->where('id', '!=', Auth()->user()->id)
        ->get();
    $writers = Modules\WriterManagement\App\Models\Writer::where('status', 1)->get();
@endphp
@php
    $config = [
        'title' => 'Select Estimate Number',
        'liveSearch' => true,
        'placeholder' => 'Search Estimate Number...',
        'showTick' => true,
        'actionsBox' => true,
    ];
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


    <div class="content" style="padding-top: 20px;margin-left: 10px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/job-card-management">Job Card </a></li>
                <li class="breadcrumb-item "><a href="/job-card-management/manage/list/{{$job_register->id}}/{{$job_register->estimate_document_id}}">Job No {{$job_register->sr_no}}</a></li>
                <li class="breadcrumb-item ">{{$estimate_detail->language->name}}</li>
            </ol>
        </nav>
        <x-adminlte-card title="Job Card" theme="success" icon="fas fa-lg fa-person">
           
            <form action="{{ route('jobcardmanagement.store') }}" method="POST">
                @csrf
                <div id="repeater">
                    <div class="repeater-item mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Part Copy 1</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row pt-2">
                                                <x-adminlte-input name="t_unit[0]" placeholder="Unit" fgroup-class="col-md-2"
                                                value="{{ old('t_unit[0]') }}" label="T Unit" required />
                                                <x-adminlte-select name="t_writer[0]" fgroup-class="col-md-2" required
                                                    value="{{ old('t_writer[0]') }}" label="T Writer">
                                                    <option value="">Select Writer</option>
                                                    @foreach ($writers as $writer)
                                                        <option value="{{ $writer->id }}">{{ $writer->writer_name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="t_pd[0]" placeholder="PD" fgroup-class="col-md-2"
                                                    type='date' value="{{ old('t_pd[0]', getCurrentDate()) }}"
                                                    label="T PD" min="{{ getCurrentDate() }}" />
                                                <x-adminlte-input name="t_cr[0]" placeholder="CR" fgroup-class="col-md-2"
                                                    type='date' value="{{ old('t_cr[0]', getCurrentDate()) }}"
                                                    label="T CR" min="{{ getCurrentDate() }}" />
                                                <x-adminlte-select name="t_cnc[0]" label="T C/CN" fgroup-class="col-md-2">
                                                        <option value="">Select C/CN</option>
                                                        <option value="C">C</option>
                                                        <option value="CN">CN</option>
                                                </x-adminlte-select>
                                                <x-adminlte-input name="t_dv[0]" placeholder="DV" fgroup-class="col-md-2"
                                                    value="{{ old('t_dv[0]') }}" label="T DV" />
                                                <x-adminlte-input name="t_fqc[0]" placeholder="QC" fgroup-class="col-md-2"
                                                    value="{{ old('t_fqc[0]') }}" label="T F/QC" />
                                                <x-adminlte-input name="t_sentdate[0]" placeholder="Sent Date"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('t_sentdate[0]') }}"
                                                    label="T Sent Date" min="{{ getCurrentDate() }}" />
                                                    <x-adminlte-input name="v_unit[0]" placeholder="V Unit" fgroup-class="col-md-2"
                                                    value="{{ old('v_unit[0]') }}" label="V Unit" />
                                                <x-adminlte-select name="v_employee_code[0]" fgroup-class="col-md-2" 
                                                    value="{{ old('v_employee_code[0]') }}" label="V Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="v_pd[0]" placeholder="V PD" fgroup-class="col-md-2"
                                                    value="{{ old('v_pd[0]') }}" label="V PD" type='date' />
                                                <x-adminlte-input name="v_cr[0]" placeholder="V CR" fgroup-class="col-md-2"
                                                    value="{{ old('v_cr[0]') }}" label="V CR" type='date' />
                                                    <x-adminlte-input name="v2_unit[0]" placeholder="V2 Unit" fgroup-class="col-md-2"
                                                    value="{{ old('v2_unit[0]') }}" label="V2 Unit" />
                                                    <x-adminlte-select name="v2_employee_code[0]" fgroup-class="col-md-2" 
                                                    value="{{ old('v2_employee_code[0]') }}" label="V2 Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="v2_pd[0]" placeholder="V2 PD" fgroup-class="col-md-2"
                                                    value="{{ old('v2_pd[0]') }}" label="V2 PD" type='date' />
                                                <x-adminlte-input name="v2_cr[0]" placeholder="V2 CR" fgroup-class="col-md-2"
                                                    value="{{ old('v2_cr[0]') }}" label="V2 CR" type='date' />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row pt-2">
                                                <x-adminlte-input name="bt_unit[0]" placeholder="Unit" fgroup-class="col-md-2"
                                                    value="{{ old('bt_unit[0]') }}" label="BT Unit" />
                                                <x-adminlte-select name="bt_writer[0]" fgroup-class="col-md-2"
                                                    value="{{ old('bt_writer[0]') }}" label="BT Writer">
                                                    <option value="">Select Writer</option>
                                                    @foreach ($writers as $writer)
                                                        <option value="{{ $writer->id }}">{{ $writer->writer_name }}
                                                        </option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="bt_pd[0]" placeholder="PD" fgroup-class="col-md-2"
                                                    type='date' value="{{ old('bt_pd[0]') }}"
                                                    label="BT PD" min="{{ getCurrentDate() }}" />
                                                <x-adminlte-input name="bt_cr[0]" placeholder="CR" fgroup-class="col-md-2"
                                                    type='date' value="{{ old('bt_cr[0]') }}"
                                                    label="BT CR" min="{{ getCurrentDate() }}" />
                                                
                                                <x-adminlte-select name="bt_cnc[0]" label="BT C/CN" fgroup-class="col-md-2">
                                                    <option value="">Select C/CN</option>
                                                    <option value="C">C</option>
                                                    <option value="CN">CN</option>
                                                </x-adminlte-select>
                                                <x-adminlte-input name="bt_dv[0]" placeholder="DV" fgroup-class="col-md-2"
                                                    value="{{ old('bt_dv[0]') }}" label="BT DV" />
                                                <x-adminlte-input name="bt_fqc[0]" placeholder="QC" fgroup-class="col-md-2"
                                                    value="{{ old('bt_fqc[0]') }}" label="BT F/QC" />
                                                <x-adminlte-input name="bt_sentdate[0]" placeholder="Sent Date"
                                                    fgroup-class="col-md-2" type='date'
                                                    value="{{ old('bt_sentdate[0]') }}"
                                                    label="BT Sent Date" min="{{ getCurrentDate() }}" />
                                                    <x-adminlte-input name="btv_unit[0]" placeholder="BTV Unit" fgroup-class="col-md-2"
                                                    value="{{ old('btv_unit[0]') }}" label="BTV Unit" />
                                                <x-adminlte-select name="btv_employee_code[0]" fgroup-class="col-md-2" 
                                                    value="{{ old('btv_employee_code[0]') }}" label="BTV Employee">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </x-adminlte-select>
                                                <x-adminlte-input name="btv_pd[0]" placeholder="BTV PD" fgroup-class="col-md-2"
                                                    value="{{ old('btv_pd[0]') }}" label="BTV PD" type='date' />
                                                <x-adminlte-input name="btv_cr[0]" placeholder="BTV CR" fgroup-class="col-md-2"
                                                    value="{{ old('btv_cr[0]') }}" label="BTV CR" type='date' />
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <x-adminlte-input name="job_no[0]" type="hidden" fgroup-class="col-md-3"
                                        value="{{ $job_register->sr_no }}" />
                                    <x-adminlte-input name="estimate_detail_id[0]" type="hidden" fgroup-class="col-md-3"
                                        value="{{ $estimate_detail->id }}" />
        
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-danger remove-item mt-3 mb-3"
                                style="float:right;width: 100px">Remove</button>
                        </div>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-primary mt-5" id="add-item">Add Item</button>
                <br>
                <x-adminlte-button label="Submit" type="submit" class="mt-3" />

            </form>
        </x-adminlte-card>
    </div>

</div>
<script>
   $(document).ready(function() {
    let itemIndex = 1;

    $('#add-item').click(function() {
        let newItem = $('.repeater-item.mt-3:first').clone();
        newItem.find('input, select').each(function() {
            $(this).val('');
            let name = $(this).attr('name');
            if (name == 'verification_2[0]') {
                name = 'verification_2[' + itemIndex + ']';
            } else {
                name = name.replace(/\d+/, itemIndex);
            }
            $(this).attr('name', name);
        });
        newItem.find('.card-title').html('Part Copy ' + (itemIndex + 1));
        newItem.appendTo('#repeater');
        itemIndex++;
    });

    $(document).on('click', '.remove-item', function() {
        if ($('.repeater-item').length > 1) {
            $(this).closest('.repeater-item').remove();
            updateIndices();
        }
    });

    function updateIndices() {
        itemIndex = 0;
        $('.repeater-item').each(function() {
            let newItem = $(this);
            newItem.find('input, select').each(function() {
                let name = $(this).attr('name');
                if (name == 'verification_2[0]') {
                    name = 'verification_2[' + itemIndex + ']';
                } else {
                    name = name.replace(/\d+/, itemIndex);
                }
                $(this).attr('name', name);
            });
            newItem.find('.card-title').html('Part Copy ' + (itemIndex + 1));
            itemIndex++;
        });
    }
});

</script>
