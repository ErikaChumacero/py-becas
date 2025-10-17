@php
    $modules = [
        [
            'title' => 'Gestionar Personas',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-user', 'route' => 'admin.persona.create', 'active' => request()->routeIs('admin.persona.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'admin.persona.index', 'active' => request()->routeIs('admin.persona.index') ],
            ],
        ],
        [
            'title' => 'Gestionar Carreras',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-solid fa-graduation-cap', 'route' => 'admin.carrera.create', 'active' => request()->routeIs('admin.carrera.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'admin.carrera.index', 'active' => request()->routeIs('admin.carrera.index') ],
            ],
        ],
        [
            'title' => 'Gestionar Convocatorias',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-file-lines', 'route' => 'admin.convocatoria.create', 'active' => request()->routeIs('admin.convocatoria.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'admin.convocatoria.index', 'active' => request()->routeIs('admin.convocatoria.index') ],
            ],
        ],
        [
            'title' => 'Gestionar Semestres',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-calendar-plus', 'route' => 'admin.semestre.create', 'active' => request()->routeIs('admin.semestre.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'admin.semestre.index', 'active' => request()->routeIs('admin.semestre.index') ],
            ],
        ],
        [
            'title' => 'Gestionar Postulaciones',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-file-circle-plus', 'route' => 'admin.postulacion.create', 'active' => request()->routeIs('admin.postulacion.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'admin.postulacion.index', 'active' => request()->routeIs('admin.postulacion.index') ],
            ],
        ],
        [
            'title' => 'Gestionar Documentos',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-file', 'route' => 'admin.documento.create', 'active' => request()->routeIs('admin.documento.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'admin.documento.index', 'active' => request()->routeIs('admin.documento.index') ],
            ],
        ],
        [
            'title' => 'Gestionar Tipos de Beca',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-square-plus', 'route' => 'admin.tipobeca.create', 'active' => request()->routeIs('admin.tipobeca.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'admin.tipobeca.index', 'active' => request()->routeIs('admin.tipobeca.index') ],
            ],
        ],
        [
            'title' => 'Gestionar Requisitos',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-square-check', 'route' => 'admin.requisito.create', 'active' => request()->routeIs('admin.requisito.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'admin.requisito.index', 'active' => request()->routeIs('admin.requisito.index') ],
            ],
        ],
        [
            'title' => 'Historial de Estados',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-clock', 'route' => 'admin.historial.create', 'active' => request()->routeIs('admin.historial.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'admin.historial.index', 'active' => request()->routeIs('admin.historial.index') ],
            ],
        ],
    ];
@endphp

<style>
    .steelblue-bg { background-color: #1f3a50; }
    .steelblue-border { border-color: #173041; }
    .steelblue-hover:hover { background-color: #173041; }
    .steelblue-chip { background-color: rgba(31,58,80,0.6); border-color: #173041; }
    .steelblue-active { background-color: #173041; }
    .text-white-80 { color: rgba(255,255,255,0.8); }
    .hover-bg-steel { transition: background-color .15s ease; }
}</style>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full steelblue-bg border-r steelblue-border sm:translate-x-0 text-white"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto steelblue-bg">
        @php($u = session('usuario'))
        @if($u)
            <div class="mb-4 p-3 rounded steelblue-chip border steelblue-border">
                <div class="text-sm font-semibold">{{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</div>
                <div class="text-xs text-white-80 truncate">{{ $u['correo'] ?? '' }}</div>
            </div>
        @endif
        <ul class="space-y-4 font-medium">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-white rounded-lg hover-bg-steel steelblue-hover {{ request()->routeIs('admin.dashboard') ? 'steelblue-active' : '' }}">
                    <span class="w-5 h-5 inline-flex justify-center items-center "><i class="fa-solid fa-gauge-high text-white/80"></i></span>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            @foreach ($modules as $module)
                <li>
                    <div class="px-3 py-2 text-xs font-semibold text-white-80 uppercase">{{ $module['title'] }}</div>
                    <ul class="mt-1 space-y-1">
                        @foreach ($module['items'] as $item)
                            <li>
                                <a href="{{ route($item['route']) }}" class="flex items-center p-2 text-white rounded-lg hover-bg-steel steelblue-hover {{ $item['active'] ? 'steelblue-active' : '' }}">
                                    <span class="w-5 h-5 inline-flex justify-center items-center "><i class="{{ $item['icon'] }} text-white/80"></i></span>
                                    <span class="ms-3">{{ $item['name'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
