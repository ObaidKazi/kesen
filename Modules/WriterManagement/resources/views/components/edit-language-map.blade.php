@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\preloaderHelper')

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
        <x-adminlte-card title="New Language Map" theme="success"  >
            <form action="{{ route('writermanagement.editLanguageMap', [$id, $language_map->id]) }}" method="PUT" >
                @method('PUT')
                @csrf
                <div class="row pt-2">
                    <x-adminlte-select name="language" fgroup-class="col-md-6" required >
                        <option value="">Language</option>
                        @foreach($languages as $language)
                            <option value="{{ $language->id }}" @if($language_map->language_id == $language->name) selected  @endif>{{ $language->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-input name="per_unit_charges"  placeholder="Per Unit Charges"
                        fgroup-class="col-md-6" value="{{ $language_map->per_unit_charges}}" />
                        <x-adminlte-input name="checking_charges"  placeholder="Checking Charges"
                        fgroup-class="col-md-6" value="{{ $language_map->checking_charges }}"/>
                        <x-adminlte-input name="bt_charges"  placeholder="BT Charges"
                        fgroup-class="col-md-6" type='text' value="{{ $language_map->bt_charges }}"/>
                        <x-adminlte-input name="bt_checking_charges"  placeholder="BT Checking Charges"
                        fgroup-class="col-md-6" value="{{ $language_map->bt_checking_charges }}"/>
                        <x-adminlte-input name="advertising_charges"  placeholder="Advertising Charges"
                        fgroup-class="col-md-6" value="{{ $language_map->advertising_charges }}"/>
                        
                </div>
                
                <x-adminlte-button label="Submit" type="submit" class="mt-3"/>

            </form>
        </x-adminlte-card>
    </div>
</div>