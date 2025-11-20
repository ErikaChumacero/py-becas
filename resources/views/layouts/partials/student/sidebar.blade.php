@php
    $modules = [
        [ 'name' => 'Mis Postulaciones', 'icon' => 'fa-solid fa-file-signature', 'route' => 'estudiante.postulacion.index', 'active' => request()->routeIs('estudiante.postulacion.*') ],
        [ 'name' => 'Mis Documentos', 'icon' => 'fa-solid fa-folder-open', 'route' => 'estudiante.documento.index', 'active' => request()->routeIs('estudiante.documento.*') ],
        [ 'name' => 'Historial de Estados', 'icon' => 'fa-solid fa-clock-rotate-left', 'route' => 'estudiante.historial.index', 'active' => request()->routeIs('estudiante.historial.*') ],
        [ 'name' => 'Convocatorias', 'icon' => 'fa-solid fa-bullhorn', 'route' => 'estudiante.convocatoria.index', 'active' => request()->routeIs('estudiante.convocatoria.*') ],
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
        display: block;
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
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: var(--sidebar-text);
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 1.2rem;
    }
    
    .sidebar-toggle:hover {
        background: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.3);
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
    class="fixed top-0 left-0 z-40 w-56 h-screen transition-all duration-300 -translate-x-full sidebar-gradient border-r border-slate-700/50 sm:translate-x-0 sidebar-font flex flex-col"
    aria-label="Sidebar">
    <!-- Header del Sidebar con Perfil -->
    <div class="h-16 px-4 border-b border-slate-700/30 flex-shrink-0 flex items-center justify-center">
        @php($u = session('usuario'))
        @if($u)
            <a href="{{ route('estudiante.perfil.index') }}" class="user-profile block cursor-pointer group w-full flex items-start gap-2 bg-slate-700/20 rounded-lg px-2 py-1 border border-slate-700/30 hover:bg-slate-700/30 transition-all h-full">
                <div class="bg-blue-500/40 rounded-full w-9 h-9 flex items-center justify-center border border-blue-400/60 group-hover:border-blue-300/80 transition-all flex-shrink-0 mt-0.5">
                    <span class="text-xs font-bold text-white">
                        {{ strtoupper(substr($u['nombre'] ?? '', 0, 1)) }}{{ strtoupper(substr($u['apellido'] ?? '', 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0 flex flex-col justify-center">
                    <div class="text-xs font-semibold text-white truncate">{{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</div>
                    <div class="text-xs text-blue-200/80 truncate">Estudiante</div>
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
                    <a href="{{ route('estudiante.dashboard') }}" class="sidebar-item {{ request()->routeIs('estudiante.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
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
                                @if(strpos($module['icon'], 'file-signature') !== false)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @elseif(strpos($module['icon'], 'folder') !== false)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                @elseif(strpos($module['icon'], 'clock') !== false)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif(strpos($module['icon'], 'bullhorn') !== false)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.437-1.946V5.882m2.437 0A18.627 18.627 0 005.5 9.75m0 0A18.627 18.627 0 012.063 15.195m0 0h15.75m-8.5-1.5a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
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
