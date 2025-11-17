@php
    $modules = [
        [ 'name' => 'Gestionar Personas', 'icon' => 'fa-solid fa-users', 'route' => 'admin.persona.index', 'active' => request()->routeIs('admin.persona.*') ],
        [ 'name' => 'Gestionar Gestiones', 'icon' => 'fa-solid fa-calendar-days', 'route' => 'admin.gestion.index', 'active' => request()->routeIs('admin.gestion.*') ],
        [ 'name' => 'Gestionar Niveles', 'icon' => 'fa-solid fa-layer-group', 'route' => 'admin.nivel.index', 'active' => request()->routeIs('admin.nivel.*') ],
        [ 'name' => 'Gestionar Materias', 'icon' => 'fa-solid fa-chalkboard', 'route' => 'admin.materia.index', 'active' => request()->routeIs('admin.materia.*') ],
        [ 'name' => 'Asignar Materias a Maestros', 'icon' => 'fa-solid fa-chalkboard-user', 'route' => 'admin.maestromater.index', 'active' => request()->routeIs('admin.maestromater.*') ],
        [ 'name' => 'Gestionar Inscripciones', 'icon' => 'fa-solid fa-file-signature', 'route' => 'admin.inscripcion.index', 'active' => request()->routeIs('admin.inscripcion.*') ],
        [ 'name' => 'Gestionar Becas', 'icon' => 'fa-solid fa-award', 'route' => 'admin.beca.index', 'active' => request()->routeIs('admin.beca.*') ],
        [ 'name' => 'Detalle de Mensualidades', 'icon' => 'fa-solid fa-file-invoice-dollar', 'route' => 'admin.detallemensualidad.index', 'active' => request()->routeIs('admin.detallemensualidad.*') ],
        [ 'name' => 'Gestionar Mensualidades', 'icon' => 'fa-solid fa-money-bill', 'route' => 'admin.mensualidad.index', 'active' => request()->routeIs('admin.mensualidad.*') ],
    ];
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Variables de color modernas - Sea Green Theme 🌊 */
    :root {
        --sidebar-bg: linear-gradient(180deg, #0d2818 0%, #1a3d2e 100%);
        --sidebar-hover: rgba(60, 179, 113, 0.15);
        --sidebar-active: linear-gradient(135deg, #3CB371 0%, #2E8B57 100%);
        --sidebar-border: rgba(60, 179, 113, 0.15);
        --sidebar-text: #e8f5e9;
        --sidebar-text-muted: #81c784;
        --sidebar-icon: #66bb6a;
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
        background: rgba(34, 197, 94, 0.08);
        border: 1px solid rgba(134, 239, 172, 0.15);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    
    .user-profile:hover {
        background: rgba(34, 197, 94, 0.12);
        border-color: rgba(134, 239, 172, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
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
        box-shadow: 0 4px 16px rgba(46, 139, 87, 0.4), 0 0 20px rgba(60, 179, 113, 0.2);
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
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full sidebar-gradient border-r border-green-900/30 sm:translate-x-0 sidebar-font"
    aria-label="Sidebar">
    <div class="h-full px-4 pb-4 overflow-y-auto sidebar-scroll">
        @php($u = session('usuario'))
        @if($u)
            <a href="{{ route('admin.perfil.index') }}" class="user-profile block cursor-pointer group">
                <div class="flex items-center gap-3">
                    <div class="bg-green-200/15 rounded-full w-12 h-12 flex items-center justify-center border-2 border-green-200/30 group-hover:border-green-300/50 transition-all shadow-lg shadow-green-200/10">
                        <span class="text-lg font-bold text-green-200">
                            {{ strtoupper(substr($u['nombre'] ?? '', 0, 1)) }}{{ strtoupper(substr($u['apellido'] ?? '', 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="user-name">{{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</div>
                        <div class="user-email truncate">{{ $u['correo'] ?? '' }}</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-green-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
