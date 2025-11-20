@php
    $modules = [
        [ 
            'name' => 'Personas', 
            'icon' => 'users', 
            'route' => 'secretaria.persona.index', 
            'active' => request()->routeIs('secretaria.persona.*'),
            'description' => 'Gestionar usuarios'
        ],
        [ 
            'name' => 'Inscripciones', 
            'icon' => 'file-signature', 
            'route' => 'secretaria.inscripcion.index', 
            'active' => request()->routeIs('secretaria.inscripcion.*'),
            'description' => 'Matrículas de estudiantes'
        ],
        [ 
            'name' => 'Mensualidades', 
            'icon' => 'money', 
            'route' => 'secretaria.mensualidad.index', 
            'active' => request()->routeIs('secretaria.mensualidad.*'),
            'description' => 'Registro de pagos'
        ],
        [ 
            'name' => 'Becas', 
            'icon' => 'award', 
            'route' => 'secretaria.beca.index', 
            'active' => request()->routeIs('secretaria.beca.*'),
            'description' => 'Sistema de becas'
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
    
    <!-- Contenido del Sidebar -->
    <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scroll flex flex-col">
        <nav class="flex-1">
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('secretaria.dashboard') }}" class="sidebar-item {{ request()->routeIs('secretaria.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                        <span class="sidebar-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </span>
                        <span class="sidebar-item-text">Dashboard</span>
                    </a>
                </li>
                
                <div class="sidebar-divider"></div>
                
                <!-- Categoría: Gestión -->
                <div class="menu-category">Gestión</div>
                
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
                                @elseif($module['icon'] === 'file-signature')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @elseif($module['icon'] === 'money')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif($module['icon'] === 'award')
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
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
