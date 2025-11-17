<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Abrir sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex ms-2 md:me-24">
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-green-600">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Colegio Cristiana Camireña
                    </span>
                </a>
            </div>
            <div class="flex items-center gap-4">
                @php($u = session('usuario'))
                @if($u)
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-semibold text-gray-900">{{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</p>
                            <p class="text-xs text-gray-500">Administrador</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold border-2 border-green-200">
                            {{ strtoupper(substr($u['nombre'] ?? '', 0, 1)) }}{{ strtoupper(substr($u['apellido'] ?? '', 0, 1)) }}
                        </div>
                    </div>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden md:inline">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
