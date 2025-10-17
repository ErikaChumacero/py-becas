@php
    $modules = [
        [
            'title' => 'Mis Postulaciones',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-file-circle-plus', 'route' => 'estudiante.postulacion.create', 'active' => request()->routeIs('estudiante.postulacion.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'estudiante.postulacion.index', 'active' => request()->routeIs('estudiante.postulacion.index') ],
            ],
        ],
        [
            'title' => 'Mis Documentos',
            'items' => [
                [ 'name' => 'Formulario', 'icon' => 'fa-regular fa-file', 'route' => 'estudiante.documento.create', 'active' => request()->routeIs('estudiante.documento.create') ],
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-list', 'route' => 'estudiante.documento.index', 'active' => request()->routeIs('estudiante.documento.index') ],
            ],
        ],
        [
            'title' => 'Historial de Estados',
            'items' => [
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-clock', 'route' => 'estudiante.historial.index', 'active' => request()->routeIs('estudiante.historial.index') ],
            ],
        ],
        [
            'title' => 'Convocatorias',
            'items' => [
                [ 'name' => 'Listado', 'icon' => 'fa-regular fa-bell', 'route' => 'estudiante.convocatoria.index', 'active' => request()->routeIs('estudiante.convocatoria.index') ],
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
    .bg-white-10 { background-color: rgba(255,255,255,0.1); }
    .bg-white-06 { background-color: rgba(255,255,255,0.06); }
    .border-white-12 { border-color: rgba(255,255,255,0.12); }
    .border-white-16 { border-color: rgba(255,255,255,0.16); }
    .hover-bg-steel { transition: background-color .15s ease; }
</style>

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
                <a href="{{ route('estudiante.dashboard') }}" class="flex items-center p-2 text-white rounded-lg hover-bg-steel steelblue-hover {{ request()->routeIs('estudiante.dashboard') ? 'steelblue-active' : '' }}">
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
