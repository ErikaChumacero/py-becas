@php
    // Módulos disponibles para Tutor
    $modules = [
        [ 'name' => 'Mis Hijos', 'icon' => 'fa-solid fa-children', 'route' => 'tutor.hijos.index', 'active' => request()->routeIs('tutor.hijos.*') ],
        [ 'name' => 'Mensualidades', 'icon' => 'fa-solid fa-money-bill', 'route' => 'tutor.mensualidad.index', 'active' => request()->routeIs('tutor.mensualidad.*') ],
        [ 'name' => 'Becas', 'icon' => 'fa-solid fa-graduation-cap', 'route' => 'tutor.beca.index', 'active' => request()->routeIs('tutor.beca.*') ],
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
        display: block;
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
        padding: 8px 12px;
        margin-bottom: 2px;
        border-radius: 8px;
        color: var(--sidebar-text);
        font-size: 0.8125rem;
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
        min-width: 20px;
        min-height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        color: var(--sidebar-icon);
        font-size: 0.9rem;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    
    .sidebar-icon svg {
        width: 100%;
        height: 100%;
        display: block;
    }
    
    .sidebar-collapsed .sidebar-icon {
        margin-right: 0;
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
        margin: 8px 0;
    }
    
    /* Sidebar colapsable */
    .sidebar-collapsed {
        width: 80px;
    }
    
    .sidebar-collapsed .sidebar-item span:not(.sidebar-icon) {
        display: none;
    }
    
    .sidebar-collapsed .sidebar-item {
        justify-content: center;
        padding: 8px;
    }
    
    .sidebar-item-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Botón toggle */
    .sidebar-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 8px 12px;
        margin-bottom: 8px;
        border-radius: 8px;
        background: rgba(60, 179, 113, 0.1);
        border: 1px solid rgba(60, 179, 113, 0.2);
        color: var(--sidebar-text);
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 1.2rem;
    }
    
    .sidebar-toggle:hover {
        background: rgba(60, 179, 113, 0.2);
        border-color: rgba(60, 179, 113, 0.3);
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
        margin-left: 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        z-index: 50;
    }
    
    .sidebar-collapsed .sidebar-item:hover::after {
        opacity: 1;
    }
    
    /* Ajuste del contenedor principal cuando sidebar está colapsado */
    body.sidebar-collapsed .sm\:ml-64 {
        margin-left: 80px;
    }
</style>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-56 h-screen transition-all duration-300 -translate-x-full sidebar-gradient border-r border-green-900/30 sm:translate-x-0 sidebar-font flex flex-col"
    aria-label="Sidebar">
    <!-- Header del Sidebar con Perfil -->
    <div class="h-16 px-4 border-b border-green-700/30 flex-shrink-0 flex items-center justify-center">
        @php($u = session('usuario'))
        @if($u)
            <a href="{{ route('tutor.perfil.index') }}" class="user-profile block cursor-pointer group w-full flex items-start gap-2 bg-green-700/20 rounded-lg px-2 py-1 border border-green-700/30 hover:bg-green-700/30 transition-all h-full">
                <div class="bg-green-500/40 rounded-full w-9 h-9 flex items-center justify-center border border-green-400/60 group-hover:border-green-300/80 transition-all flex-shrink-0 mt-0.5">
                    <span class="text-xs font-bold text-white">
                        {{ strtoupper(substr($u['nombre'] ?? '', 0, 1)) }}{{ strtoupper(substr($u['apellido'] ?? '', 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0 flex flex-col justify-center">
                    <div class="text-xs font-semibold text-white truncate">{{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</div>
                    <div class="text-xs text-green-200/80 truncate">Tutor</div>
                </div>
            </a>
        @endif
    </div>
    
    <!-- Contenido del Sidebar -->
    <div class="flex-1 px-4 pb-4 overflow-y-auto sidebar-scroll flex flex-col">
        <nav class="flex-1">
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li class="pt-4">
                    <a href="{{ route('tutor.dashboard') }}" class="sidebar-item {{ request()->routeIs('tutor.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                        <span class="sidebar-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4V3"></path>
                            </svg>
                        </span>
                        <span class="sidebar-item-text">Dashboard</span>
                    </a>
                </li>
                
                <!-- Módulos adicionales -->
                @foreach ($modules as $module)
                    <li>
                        <a href="{{ route($module['route']) }}" class="sidebar-item {{ $module['active'] ? 'active' : '' }}" data-tooltip="{{ $module['name'] }}">
                            <span class="sidebar-icon">
                                @if(strpos($module['icon'], 'children') !== false)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                @elseif(strpos($module['icon'], 'money-bill') !== false)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif(strpos($module['icon'], 'graduation-cap') !== false)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25m20-11.002c0 5.251-4.5 9.999-10 9.999"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('logo-sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle-header');
    const header = document.getElementById('header-nav');
    
    // Cargar estado del sidebar desde localStorage
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (sidebarCollapsed) {
        toggleSidebar(true);
    }
    
    // Event listener para el botón toggle
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
            toggleSidebar(!isCollapsed);
        });
    }
    
    function toggleSidebar(collapse) {
        if (collapse) {
            sidebar.classList.add('sidebar-collapsed');
            document.body.classList.add('sidebar-collapsed');
            if (header) {
                header.style.left = '80px';
            }
            localStorage.setItem('sidebarCollapsed', 'true');
        } else {
            sidebar.classList.remove('sidebar-collapsed');
            document.body.classList.remove('sidebar-collapsed');
            if (header) {
                header.style.left = '224px';
            }
            localStorage.setItem('sidebarCollapsed', 'false');
        }
    }
});
</script>
