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
    <div class="content" style="margin-top: 20px;margin-left: 10px">
        <x-adminlte-card title="Edit Contact" theme="success"  
    >
        <form action="{{ route('clientmanagement.editContact',[$id,$contact_person->id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row pt-2">
                
                <x-adminlte-input name="name"  placeholder="Contact Person Name"
                    fgroup-class="col-md-6" required value="{{ $contact_person->name }}"/>
                <x-adminlte-input name="phone_no"  placeholder="Contact Person Number"
                    fgroup-class="col-md-6" value="{{ $contact_person->phone_no}}"/>
                    <x-adminlte-input name="landline"  placeholder="Landline Number"
                    fgroup-class="col-md-6" value="{{ $contact_person->landline}}"/>
                    <x-adminlte-input name="email"  placeholder="Email"
                    fgroup-class="col-md-6" type='email' value="{{ $contact_person->email}}"/>
                    <x-adminlte-input name="designation"  placeholder="Designation"
                    fgroup-class="col-md-6" value="{{ $contact_person->designation}}"/>
                    <x-adminlte-input name="id"  placeholder="Contact Person Name"
                    fgroup-class="col-md-6" type="hidden"  value="{{ $contact_person->id }}"/>
            </div>
            
            <x-adminlte-button label="Submit" type="submit" class="mt-3"/>

        </form>
        </x-adminlte-card>
    </div>

</div>