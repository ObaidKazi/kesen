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
        <x-adminlte-card title="Job Card" theme="success" icon="fas fa-lg fa-person">
            <h4>Job No :{{ $job_register->sr_no . '-' . $estimate_detail->lang }}</h4>
            <form action="{{ route('jobcardmanagement.store') }}" method="POST">
                @csrf
                <div id="repeater">
                    <div class="repeater-item mt-3">
                        <div class="row pt-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row pt-2">
                                        <x-adminlte-select name="t_writer[0]" fgroup-class="col-md-6" required
                                            value="{{ old('t_writer[0]') }}" label="Translation Writer">
                                            <option value="">Select Writer</option>
                                            @foreach ($writers as $writer)
                                                <option value="{{ $writer->id }}">{{ $writer->writer_name }}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="t_emp_code[0]" fgroup-class="col-md-6" required
                                            value="{{ old('t_emp_code[0]') }}" label="Translation Employee">
                                            <option value="">Select Employee</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-input name="t_pd[0]" placeholder="PD" fgroup-class="col-md-6"
                                            type='date' value="{{ old('t_pd[0]', getCurrentDate()) }}"
                                            label="Translation PD" min="{{ getCurrentDate() }}" />
                                        <x-adminlte-input name="t_cr[0]" placeholder="CR" fgroup-class="col-md-6"
                                            type='date' value="{{ old('t_cr[0]', getCurrentDate()) }}"
                                            label="Translation CR" min="{{ getCurrentDate() }}" />
                                        <x-adminlte-input name="t_cnc[0]" placeholder="CN" fgroup-class="col-md-6"
                                            value="{{ old('t_cnc[0]') }}" label="Translation C/CN" />
                                        <x-adminlte-input name="t_dv[0]" placeholder="DV" fgroup-class="col-md-6"
                                            value="{{ old('t_dv[0]') }}" label="Translation DV" />
                                        <x-adminlte-input name="t_fqc[0]" placeholder="QC" fgroup-class="col-md-6"
                                            value="{{ old('t_fqc[0]') }}" label="Translation F/QC" />
                                        <x-adminlte-input name="t_sentdate[0]" placeholder="Sent Date"
                                            fgroup-class="col-md-6" type='date'
                                            value="{{ old('t_sentdate[0]', getCurrentDate()) }}"
                                            label="Translation Sent Date" min="{{ getCurrentDate() }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row pt-2">
                                        <x-adminlte-select name="v_writer[0]" fgroup-class="col-md-6"
                                            value="{{ old('v_writer[0]') }}" label="Verifcation Writer">
                                            <option value="">Select Writer</option>
                                            @foreach ($writers as $writer)
                                                <option value="{{ $writer->id }}">{{ $writer->writer_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="v_emp_code[0]" fgroup-class="col-md-6"
                                            value="{{ old('v_emp_code[0]') }}" label="Verifcation Employee">
                                            <option value="">Select Employee</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-input name="v_pd[0]" placeholder="PD" fgroup-class="col-md-6"
                                            type='date' value="{{ old('v_pd[0]', getCurrentDate()) }}"
                                            label="Verifcation PD" min="{{ getCurrentDate() }}" />
                                        <x-adminlte-input name="v_cr[0]" placeholder="CR" fgroup-class="col-md-6"
                                            type='date' value="{{ old('v_cr[0]', getCurrentDate()) }}"
                                            label="Verifcation CR" min="{{ getCurrentDate() }}" />
                                        <x-adminlte-input name="v_cnc[0]" placeholder="CN" fgroup-class="col-md-6"
                                            value="{{ old('v_cnc[0]') }}" label="Verifcation C/CN" />
                                        <x-adminlte-input name="v_dv[0]" placeholder="DV" fgroup-class="col-md-6"
                                            value="{{ old('v_dv[0]') }}" label="Verifcation DV" />
                                        <x-adminlte-input name="v_fqc[0]" placeholder="QC" fgroup-class="col-md-6"
                                            value="{{ old('v_fqc[0]') }}" label="Verifcation F/QC" />
                                        <x-adminlte-input name="v_sentdate[0]" placeholder="Sent Date"
                                            fgroup-class="col-md-6" type='date'
                                            value="{{ old('v_sentdate[0]', getCurrentDate()) }}"
                                            label="Verifcation Sent Date" min="{{ getCurrentDate() }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row pt-2">
                                        <x-adminlte-select name="bt_writer[0]" fgroup-class="col-md-6"
                                            value="{{ old('bt_writer[0]') }}" label="Back Translation Writer">
                                            <option value="">Select Writer</option>
                                            @foreach ($writers as $writer)
                                                <option value="{{ $writer->id }}">{{ $writer->writer_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="bt_emp_code[0]" fgroup-class="col-md-6"
                                            value="{{ old('bt_emp_code[0]') }}" label="Back Translation Employee">
                                            <option value="">Select Employee</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-input name="bt_pd[0]" placeholder="PD" fgroup-class="col-md-6"
                                            type='date' value="{{ old('bt_pd[0]', getCurrentDate()) }}"
                                            label="Back Translation PD" min="{{ getCurrentDate() }}" />
                                        <x-adminlte-input name="bt_cr[0]" placeholder="CR" fgroup-class="col-md-6"
                                            type='date' value="{{ old('bt_cr[0]', getCurrentDate()) }}"
                                            label="Back Translation CR" min="{{ getCurrentDate() }}" />
                                        <x-adminlte-input name="bt_cnc[0]" placeholder="CN" fgroup-class="col-md-6"
                                            value="{{ old('bt_cnc[0]') }}" label="Back Translation C/CN" />
                                        <x-adminlte-input name="bt_dv[0]" placeholder="DV" fgroup-class="col-md-6"
                                            value="{{ old('bt_dv[0]') }}" label="Back Translation DV" />
                                        <x-adminlte-input name="bt_fqc[0]" placeholder="QC" fgroup-class="col-md-6"
                                            value="{{ old('bt_fqc[0]') }}" label="Back Translation F/QC" />
                                        <x-adminlte-input name="bt_sentdate[0]" placeholder="Sent Date"
                                            fgroup-class="col-md-6" type='date'
                                            value="{{ old('bt_sentdate[0]', getCurrentDate()) }}"
                                            label="Back Translation Sent Date" min="{{ getCurrentDate() }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row pt-2">
                                        <x-adminlte-select name="btv_writer[0]" fgroup-class="col-md-6"
                                            value="{{ old('btv_writer[0]') }}"
                                            label="Back Translation Verifcation Writer">
                                            <option value="">Select Writer</option>
                                            @foreach ($writers as $writer)
                                                <option value="{{ $writer->id }}">{{ $writer->writer_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="btv_emp_code[0]" fgroup-class="col-md-6"
                                            value="{{ old('btv_emp_code[0]') }}"
                                            label="Back Translation Verifcation Employee">
                                            <option value="">Select Employee</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-input name="btv_pd[0]" placeholder="PD" fgroup-class="col-md-6"
                                            type='date' value="{{ old('btv_pd[0]', getCurrentDate()) }}"
                                            label="Back Translation Verifcation PD" min="{{ getCurrentDate() }}" />
                                        <x-adminlte-input name="btv_cr[0]" placeholder="CR" fgroup-class="col-md-6"
                                            type='date' value="{{ old('btv_cr[0]', getCurrentDate()) }}"
                                            label="Back Translation Verifcation CR" min="{{ getCurrentDate() }}" />
                                        <x-adminlte-input name="btv_cnc[0]" placeholder="CN" fgroup-class="col-md-6"
                                            value="{{ old('btv_cnc[0]') }}"
                                            label="Back Translation Verifcation C/CN" />
                                        <x-adminlte-input name="btv_dv[0]" placeholder="DV" fgroup-class="col-md-6"
                                            value="{{ old('btv_dv[0]') }}" label="Back Translation Verifcation DV" />
                                        <x-adminlte-input name="btv_fqc[0]" placeholder="QC" fgroup-class="col-md-6"
                                            value="{{ old('btv_fqc[0]') }}"
                                            label="Back Translation Verifcation F/QC" />
                                        <x-adminlte-input name="btv_sentdate[0]" placeholder="Sent Date"
                                            fgroup-class="col-md-6" type='date'
                                            value="{{ old('btv_sentdate[0]', getCurrentDate()) }}"
                                            label="Back Translation Verifcation Sent Date"
                                            min="{{ getCurrentDate() }}" />
                                    </div>
                                </div>
                            </div>
                            <x-adminlte-input name="job_no[0]" type="hidden" fgroup-class="col-md-6"
                                value="{{ $job_register->sr_no }}" />
                            <x-adminlte-input name="estimate_detail_id[0]" type="hidden" fgroup-class="col-md-6"
                                value="{{ $estimate_detail->id }}" />

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
            console.log(itemIndex);
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
            newItem.appendTo('#repeater');
            itemIndex++;
        });

        $(document).on('click', '.remove-item', function() {
            if ($('.repeater-item').length > 1) {
                itemIndex--;
                $(this).closest('.repeater-item').remove();
                updateIndices();
            }
        });

        function updateIndices() {
            itemIndex = 0;
            $('.repeater-item').each(function() {
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



                itemIndex++;
            });
        }
    });
</script>
