<nav id="header-nav" class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200/80 shadow-sm h-16 transition-all duration-300">
    <div class="h-full px-4 lg:px-6">
        <div class="flex items-center justify-between h-full">
            <!-- Left Section: Toggle + Brand -->
            <div class="flex items-center gap-3">
                <!-- Hamburger Menu Button (Desktop) -->
                <button id="sidebar-toggle-header" type="button" 
                    class="hidden sm:flex items-center justify-center w-10 h-10 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500/20">
                    <svg class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Mobile Menu Button -->
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" 
                    aria-controls="logo-sidebar" type="button" 
                    class="sm:hidden flex items-center justify-center w-10 h-10 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all">
                    <span class="sr-only">Abrir menú</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Brand -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
                    <span class="hidden lg:block text-lg font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent uppercase">
                        ESCUELA CRISTIANA CAMIREÑA
                    </span>
                </a>
            </div>

            <!-- Right Section: Profile -->
            <div class="flex items-center gap-2 md:gap-3">
                <!-- User Profile -->
                @php($u = session('usuario'))
                @if($u)
                    <div class="relative group">
                        <button class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-white font-bold shadow-md hover:shadow-lg transition-all ring-2 ring-white">
                            {{ strtoupper(substr($u['nombre'] ?? '', 0, 1)) }}{{ strtoupper(substr($u['apellido'] ?? '', 0, 1)) }}
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ $u['nombre'] ?? '' }}</p>
                                <p class="text-xs text-gray-500">{{ $u['correo'] ?? '' }}</p>
                            </div>
                                <div class="py-2">
                                    <a href="{{ route('admin.perfil.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-user-circle w-4"></i>
                                        <span>Mi Perfil</span>
                                    </a>
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-cog w-4"></i>
                                        <span>Configuración</span>
                                    </a>
                                </div>
                                <div class="border-t border-gray-100 py-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i class="fas fa-sign-out-alt w-4"></i>
                                            <span>Cerrar Sesión</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<style>
    /* Animación del botón hamburguesa */
    #sidebar-toggle-header:hover svg {
        transform: rotate(90deg);
    }
    
    /* Mejora del dropdown */
    .group:hover .group-hover\:opacity-100 {
        pointer-events: auto;
    }
    
    .group .group-hover\:opacity-100 {
        pointer-events: none;
    }
</style>
