@php
    $modules = [
        [ 
            'name' => 'Personas', 
            'icon' => 'users', 
            'route' => 'admin.persona.index', 
            'active' => request()->routeIs('admin.persona.*'),
            'description' => 'Gestionar usuarios del sistema'
        ],
        [ 
            'name' => 'Gestiones', 
            'icon' => 'calendar', 
            'route' => 'admin.gestion.index', 
            'active' => request()->routeIs('admin.gestion.*'),
            'description' => 'Años escolares'
        ],
        [ 
            'name' => 'Niveles', 
            'icon' => 'layers', 
            'route' => 'admin.nivel.index', 
            'active' => request()->routeIs('admin.nivel.*'),
            'description' => 'Niveles educativos'
        ],
        [ 
            'name' => 'Materias', 
            'icon' => 'book', 
            'route' => 'admin.materia.index', 
            'active' => request()->routeIs('admin.materia.*'),
            'description' => 'Asignaturas del colegio'
        ],
        [ 
            'name' => 'Asignar Materias', 
            'icon' => 'chalkboard', 
            'route' => 'admin.maestromater.index', 
            'active' => request()->routeIs('admin.maestromater.*'),
            'description' => 'Maestros y materias'
        ],
        [ 
            'name' => 'Inscripciones', 
            'icon' => 'file-signature', 
            'route' => 'admin.inscripcion.index', 
            'active' => request()->routeIs('admin.inscripcion.*'),
            'description' => 'Matrículas de estudiantes'
        ],
        [ 
            'name' => 'Becas', 
            'icon' => 'award', 
            'route' => 'admin.beca.index', 
            'active' => request()->routeIs('admin.beca.*'),
            'description' => 'Sistema de becas'
        ],
        [ 
            'name' => 'Detalle Mensualidades', 
            'icon' => 'file-invoice', 
            'route' => 'admin.detallemensualidad.index', 
            'active' => request()->routeIs('admin.detallemensualidad.*'),
            'description' => 'Configuración de pagos'
        ],
        [ 
            'name' => 'Mensualidades', 
            'icon' => 'money', 
            'route' => 'admin.mensualidad.index', 
            'active' => request()->routeIs('admin.mensualidad.*'),
            'description' => 'Registro de pagos'
        ],
    ];

@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Variables de color modernas - Sea Green Theme 🌊 */
    :root {
        --sidebar-bg: linear-gradient(180deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
        --sidebar-hover: rgba(16, 185, 129, 0.1);
        --sidebar-active: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --sidebar-border: rgba(16, 185, 129, 0.15);
        --sidebar-text: #f0fdf4;
        --sidebar-text-muted: #86efac;
        --sidebar-icon: #6ee7b7;
        --sidebar-shadow: rgba(0, 0, 0, 0.3);
    }
    
    /* Tipografía moderna */
    .sidebar-font {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        letter-spacing: -0.01em;
    }
    
    /* Fondo con gradiente mejorado */
    .sidebar-gradient {
        background: var(--sidebar-bg);
        backdrop-filter: blur(10px);
        box-shadow: 4px 0 24px var(--sidebar-shadow);
    }
    
    /* Header del sidebar con perfil */
    .sidebar-header {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.1) 100%);
        border-bottom: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    /* Perfil de usuario mejorado */
    .user-profile {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .user-profile:hover {
        background: rgba(16, 185, 129, 0.15);
        border-color: rgba(110, 231, 183, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    
    .user-avatar {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    
    /* Botones del menú mejorados */
    .sidebar-item {
        display: flex;
        align-items: center;
        padding: 10px 12px;
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
        width: 4px;
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
        transform: scaleY(0);
        transition: transform 0.2s ease;
        border-radius: 0 4px 4px 0;
    }
    
    .sidebar-item:hover {
        background: var(--sidebar-hover);
        color: #ffffff;
        transform: translateX(6px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
    }
    
    .sidebar-item:hover::before {
        transform: scaleY(1);
    }
    
    .sidebar-item.active {
        background: var(--sidebar-active);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4), 0 0 20px rgba(16, 185, 129, 0.2);
    }
    
    .sidebar-item.active::before {
        transform: scaleY(1);
        background: #ffffff;
    }
    
    /* Iconos mejorados */
    .sidebar-icon {
        width: 22px;
        height: 22px;
        min-width: 22px;
        min-height: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: var(--sidebar-icon);
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    
    .sidebar-icon svg {
        width: 100%;
        height: 100%;
        display: block;
    }
    
    .sidebar-item:hover .sidebar-icon,
    .sidebar-item.active .sidebar-icon {
        color: #ffffff;
        transform: scale(1.15) rotate(5deg);
    }
    
    /* Badge para notificaciones */
    .menu-badge {
        margin-left: auto;
        padding: 2px 8px;
        font-size: 0.625rem;
        font-weight: 700;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    
    /* Descripción del item (tooltip) */
    .item-description {
        font-size: 0.7rem;
        color: var(--sidebar-text-muted);
        margin-top: 2px;
        opacity: 0.8;
    }
    
    /* Scrollbar personalizado */
    .sidebar-scroll::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.3);
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: rgba(16, 185, 129, 0.3);
        border-radius: 3px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(16, 185, 129, 0.5);
    }
    
    /* Separador sutil */
    .sidebar-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, var(--sidebar-border) 50%, transparent 100%);
        margin: 12px 0;
    }
    
    /* Sidebar colapsable */
    .sidebar-collapsed {
        width: 80px !important;
    }
    
    .sidebar-collapsed .sidebar-item span:not(.sidebar-icon) {
        display: none;
    }
    
    .sidebar-collapsed .sidebar-item {
        justify-content: center;
        padding: 10px;
    }
    
    
    .sidebar-collapsed .user-profile .flex-1 {
        display: none;
    }
    
    .sidebar-item-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }
    
    /* Tooltip para sidebar colapsado */
    .sidebar-collapsed .sidebar-item {
        position: relative;
    }
    
    .sidebar-collapsed .sidebar-item::after {
        content: attr(data-tooltip);
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        margin-left: 12px;
        background: rgba(0, 0, 0, 0.9);
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        z-index: 50;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    .sidebar-collapsed .sidebar-item:hover::after {
        opacity: 1;
    }
    
    /* Ajuste del contenedor principal cuando sidebar está colapsado */
    body.sidebar-collapsed .sm\:ml-64 {
        margin-left: 80px;
    }
    
    /* Categorías del menú */
    .menu-category {
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--sidebar-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 8px 12px 4px;
        margin-top: 16px;
    }
    
    .sidebar-collapsed .menu-category {
        display: none;
    }
</style>

<aside id="logo-sidebar"
    class="fixed top-16 left-0 z-40 w-64 h-[calc(100vh-4rem)] transition-transform duration-300 -translate-x-full sidebar-gradient border-r border-green-900/30 sidebar-font flex flex-col shadow-2xl"
    aria-label="Sidebar">
    
    
    <!-- Header del Perfil -->
    @php($u = session('usuario'))
    @if($u)
        <div class="px-3 py-4 border-b border-green-900/30">
            <a href="{{ route('admin.perfil.index') }}" class="user-profile flex items-center gap-3 p-3 rounded-lg border border-green-700/30 bg-green-700/20">
                <div class="flex-shrink-0 w-9 h-9 rounded-full user-avatar flex items-center justify-center font-bold text-white text-sm">
                    {{ strtoupper(substr($u['nombre'] ?? '', 0, 1)) }}{{ strtoupper(substr($u['apellido'] ?? '', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-green-50 truncate">{{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</p>
                    <p class="text-xs text-green-200">Administrador</p>
                </div>
            </a>
        </div>
    @endif

    <!-- Contenido del Sidebar -->
    <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scroll flex flex-col">
        <nav class="flex-1">
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                        <span class="sidebar-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </span>
                        <span class="sidebar-item-text">Dashboard</span>
                    </a>
                </li>
                
                <div class="sidebar-divider"></div>
                
                <!-- Categoría: Gestión Académica -->
                <div class="menu-category">Gestión Académica</div>
                
                @foreach ($modules as $module)
                    <li>
                        <a href="{{ route($module['route']) }}" 
                           class="sidebar-item {{ $module['active'] ? 'active' : '' }}" 
                           data-tooltip="{{ $module['name'] }}">
                            <span class="sidebar-icon">
                                @if($module['icon'] === 'users')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                @elseif($module['icon'] === 'calendar')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @elseif($module['icon'] === 'layers')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                @elseif($module['icon'] === 'book')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                @elseif($module['icon'] === 'chalkboard')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                @elseif($module['icon'] === 'file-signature')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @elseif($module['icon'] === 'award')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                @elseif($module['icon'] === 'file-invoice')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @elseif($module['icon'] === 'money')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </span>
                            <span class="sidebar-item-text">{{ $module['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
