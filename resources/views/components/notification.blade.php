@if (Session::has('message'))
    <x-adminlte-alert theme="success" title="Success" dismissable id="success-msg">
        {{ Session::get('message') }}
    </x-adminlte-alert>
@endif
@if (Session::has('alert'))
    <x-adminlte-alert theme="danger" title="Danger" dismissable id="alert-msg">
        {{ Session::get('message') }}
    </x-adminlte-alert>
@endif
