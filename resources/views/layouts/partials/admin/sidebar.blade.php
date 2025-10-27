@php
    $modules = [
        [ 'name' => 'Gestionar Personas', 'icon' => 'fa-solid fa-users', 'route' => 'admin.persona.index', 'active' => request()->routeIs('admin.persona.*') ],
        [ 'name' => 'Gestionar Carreras', 'icon' => 'fa-solid fa-graduation-cap', 'route' => 'admin.carrera.index', 'active' => request()->routeIs('admin.carrera.*') ],
        [ 'name' => 'Gestionar Convocatorias', 'icon' => 'fa-solid fa-bullhorn', 'route' => 'admin.convocatoria.index', 'active' => request()->routeIs('admin.convocatoria.*') ],
        [ 'name' => 'Gestionar Semestres', 'icon' => 'fa-solid fa-calendar-days', 'route' => 'admin.semestre.index', 'active' => request()->routeIs('admin.semestre.*') ],
        [ 'name' => 'Gestionar Postulaciones', 'icon' => 'fa-solid fa-file-signature', 'route' => 'admin.postulacion.index', 'active' => request()->routeIs('admin.postulacion.*') ],
        [ 'name' => 'Gestionar Documentos', 'icon' => 'fa-solid fa-folder-open', 'route' => 'admin.documento.index', 'active' => request()->routeIs('admin.documento.*') ],
        [ 'name' => 'Gestionar Tipos de Beca', 'icon' => 'fa-solid fa-award', 'route' => 'admin.tipobeca.index', 'active' => request()->routeIs('admin.tipobeca.*') ],
        [ 'name' => 'Gestionar Requisitos', 'icon' => 'fa-solid fa-list-check', 'route' => 'admin.requisito.index', 'active' => request()->routeIs('admin.requisito.*') ],
        [ 'name' => 'Historial de Estados', 'icon' => 'fa-solid fa-clock-rotate-left', 'route' => 'admin.historial.index', 'active' => request()->routeIs('admin.historial.*') ],
    ];
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Variables de color modernas */
    :root {
        --sidebar-bg: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        --sidebar-hover: rgba(59, 130, 246, 0.1);
        --sidebar-active: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        --sidebar-border: rgba(148, 163, 184, 0.1);
        --sidebar-text: #e2e8f0;
        --sidebar-text-muted: #94a3b8;
        --sidebar-icon: #60a5fa;
    }
    
    /* Tipografía moderna */
    .sidebar-font {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        letter-spacing: -0.01em;
    }
    
    /* Fondo con gradiente */
    .sidebar-gradient {
        background: var(--sidebar-bg);
        backdrop-filter: blur(10px);
    }
    
    /* Perfil de usuario mejorado */
    .user-profile {
        background: rgba(30, 41, 59, 0.6);
        border: 1px solid var(--sidebar-border);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    
    .user-profile:hover {
        background: rgba(30, 41, 59, 0.8);
        border-color: rgba(148, 163, 184, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .user-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--sidebar-text);
        margin-bottom: 4px;
        letter-spacing: -0.02em;
    }
    
    .user-email {
        font-size: 0.75rem;
        color: var(--sidebar-text-muted);
        font-weight: 400;
    }
    
    /* Botones del menú mejorados */
    .sidebar-item {
        display: flex;
        align-items: center;
        padding: 12px 14px;
        margin-bottom: 4px;
        border-radius: 10px;
        color: var(--sidebar-text);
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .sidebar-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: var(--sidebar-icon);
        transform: scaleY(0);
        transition: transform 0.2s ease;
    }
    
    .sidebar-item:hover {
        background: var(--sidebar-hover);
        color: #ffffff;
        transform: translateX(4px);
    }
    
    .sidebar-item:hover::before {
        transform: scaleY(1);
    }
    
    .sidebar-item.active {
        background: var(--sidebar-active);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .sidebar-item.active::before {
        transform: scaleY(1);
        background: #ffffff;
    }
    
    /* Iconos mejorados */
    .sidebar-icon {
        width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: var(--sidebar-icon);
        font-size: 1rem;
        transition: all 0.2s ease;
    }
    
    .sidebar-item:hover .sidebar-icon,
    .sidebar-item.active .sidebar-icon {
        color: #ffffff;
        transform: scale(1.1);
    }
    
    /* Scrollbar personalizado */
    .sidebar-scroll::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.3);
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.3);
        border-radius: 3px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.5);
    }
    
    /* Separador sutil */
    .sidebar-divider {
        height: 1px;
        background: var(--sidebar-border);
        margin: 16px 0;
    }
</style>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full sidebar-gradient border-r border-slate-700/50 sm:translate-x-0 sidebar-font"
    aria-label="Sidebar">
    <div class="h-full px-4 pb-4 overflow-y-auto sidebar-scroll">
        @php($u = session('usuario'))
        @if($u)
            <a href="{{ route('admin.perfil.index') }}" class="user-profile block cursor-pointer group">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-500/20 rounded-full w-12 h-12 flex items-center justify-center border-2 border-blue-400/30 group-hover:border-blue-400/60 transition-all">
                        <span class="text-lg font-bold text-blue-300">
                            {{ strtoupper(substr($u['nombre'] ?? '', 0, 1)) }}{{ strtoupper(substr($u['apellido'] ?? '', 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="user-name">{{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</div>
                        <div class="user-email truncate">{{ $u['correo'] ?? '' }}</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        @endif
        
        <nav>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="sidebar-icon"><i class="fa-solid fa-house"></i></span>
                        <span>Principal</span>
                    </a>
                </li>
                
                <div class="sidebar-divider"></div>
                
                @foreach ($modules as $module)
                    <li>
                        <a href="{{ route($module['route']) }}" class="sidebar-item {{ $module['active'] ? 'active' : '' }}">
                            <span class="sidebar-icon"><i class="{{ $module['icon'] }}"></i></span>
                            <span>{{ $module['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
