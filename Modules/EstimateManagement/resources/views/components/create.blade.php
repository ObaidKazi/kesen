@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')
@php $metrics=config('services.metrix'); @endphp
@php $clients=Modules\ClientManagement\App\Models\Client::where('status',1)->get(); @endphp
@php $languages=Modules\LanguageManagement\App\Models\Language::where('status',1)->get(); @endphp
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
        <x-adminlte-card title="New Estimate" theme="success" icon="fas fa-lg fa-person">
            <form action="{{ route('estimatemanagement.store') }}" method="POST">
                @csrf
                <div class="row pt-2">
                    <x-adminlte-input name="estimate_no" placeholder="Estimate Number" fgroup-class="col-md-6" required
                        value="{{ old('estimate_no') }}" label="Estimate Number" />
                        <x-adminlte-select name="metrix" fgroup-class="col-md-6" required value="{{ old('metrix') }}"
                        label="Metrix">
                        <option value="">Select Metrix</option>
                        @foreach ($metrics as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="client_id" id="client_id" fgroup-class="col-md-6" required label="Client">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="client_contact_person_id" id="client_contact_person_id"
                        fgroup-class="col-md-6" required label="Contact Person">
                        <option value="">Select Contact Person</option>
                    </x-adminlte-select>
                    <x-adminlte-input name="headline" placeholder="Headline" fgroup-class="col-md-6" type="text"
                        value="{{ old('headline') }}" required label="Headline" />
                    <x-adminlte-input name="amount" placeholder="Amount" fgroup-class="col-md-6" type="text"
                        value="{{ old('amount') }}" required label="Amount" />
                        
                    <x-adminlte-select name="currency" placeholder="Currency" fgroup-class="col-md-6" required
                        value="{{ old('currency') }}" label="Currency">
                        
                        <option value="">Select Currency</option>
                        {!! getCurrencyDropDown() !!}
                    </x-adminlte-select>
                    <x-adminlte-input name="discount" placeholder="Discount" fgroup-class="col-md-6" type="text"
                        value="{{ old('discount') }}" required label="Discount" />
                    <x-adminlte-select name="status" fgroup-class="col-md-6" required value="{{ old('status') }}"
                        label="Status">
                        <option value="">Select Status</option>
                        <option value="0" selected>Pending</option>
                        <option value="1">Approve</option>
                        <option value="2">Reject</option>
                    </x-adminlte-select>
                    


                </div>
                <div id="repeater">
                    <div class="repeater-item mt-3">

                        <div class="row">
                            <x-adminlte-input name="document_name[0]" placeholder="Document Name"
                                fgroup-class="col-md-6" type="text" value="{{ old('document_name[0]') }}" required
                                label="Document Name" />
                            <x-adminlte-select name="type[0]" fgroup-class="col-md-6" required
                                value="{{ old('type[0]') }}" label="Type">
                                <option value="">Select Type</option>
                                <option value="word">Word</option>
                                <option value="unit">Unit</option>
                            </x-adminlte-select>
                            <x-adminlte-input name="unit[0]" placeholder="Unit" fgroup-class="col-md-6" type="text"
                                value="{{ old('unit[0]') }}" required label="Unit/Words" />
                            <x-adminlte-input name="rate[0]" placeholder="Rate" fgroup-class="col-md-6" type="text"
                                value="{{ old('rate[0]') }}" required label="Rate" />
                            <x-adminlte-input name="verification[0]" placeholder="Verification" fgroup-class="col-md-6"
                                type="text" value="{{ old('verification[0]') }}" required label="Verification" />
                                <x-adminlte-input name="layout_charges[0]" placeholder="Layout Charges"
                                fgroup-class="col-md-6" type="text" value="{{ old('layout_charges[0]') }}"
                                required label="Layout Charges" />
                                <x-adminlte-input name="back_translation[0]" placeholder="Back Translation"
                                fgroup-class="col-md-6" type="text" value="{{ old('back_translation[0]') }}"
                                required label="Back Translation" />
                                <x-adminlte-input name="verification_2[0]" placeholder="Back Translation Verification" fgroup-class="col-md-6"
                                type="text" value="{{ old('verification_2[0]') }}" required label="Back Translation Verification" />
                            <x-adminlte-input name="layout_charges_second[0]" placeholder="Layout Charges 2"
                                fgroup-class="col-md-6" type="text" value="{{ old('layout_charges_second[0]') }}"
                                required label="Layout Charges 2" />
                                <x-adminlte-select name="lang[0]" fgroup-class="col-md-6"  required value="{{ old('language') }}" label="Language">
                                    <option value="">Select Language</option>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </x-adminlte-select>
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

<script type="text/javascript">
    document.getElementById('client_id').addEventListener('change', function() {
        let client_id = this.value;
        console.log(client_id);
        $.ajax({
            url: "/estimate-management/client/" + client_id,
            method: 'GET',
            success: function(data) {
                $('#client_contact_person_id').html(data.html);
            }
        });
    });
    $(document).ready(function() {
        let itemIndex = 1;

        $('#add-item').click(function() {
            console.log(itemIndex);
            let newItem = $('.repeater-item.mt-3:first').clone();
            newItem.find('input, select').each(function() {
                $(this).val('');
                let name = $(this).attr('name');
                if(name=='verification_2[0]'){
                    name = 'verification_2['+itemIndex+']';
                }else{
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
                    if(name=='verification_2[0]'){
                    name = 'verification_2['+itemIndex+']';
                }else{
                    name = name.replace(/\d+/, itemIndex);
                }
                    $(this).attr('name', name);
                });



                itemIndex++;
            });
        }
    });
</script>
