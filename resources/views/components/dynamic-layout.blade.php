@php
    $usuario = session('usuario');
    $esAdmin = ($usuario['tipoa'] ?? '0') === '1';
    $esSecretaria = ($usuario['tipos'] ?? '0') === '1';
@endphp

@if($esAdmin)
    <x-admin-layout>
        {{ $slot }}
    </x-admin-layout>
@elseif($esSecretaria)
    <x-secretaria-layout>
        {{ $slot }}
    </x-secretaria-layout>
@else
    <x-admin-layout>
        {{ $slot }}
    </x-admin-layout>
@endif
