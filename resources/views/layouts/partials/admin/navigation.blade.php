<nav class="fixed top-0 z-50 w-full bg-blue-900 border-b border-blue-900 text-white">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-white/90 rounded-lg sm:hidden hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <div class="flex ms-2 md:me-24">
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-white">Panel</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @php($u = session('usuario'))
                @if($u)
                    <div class="text-sm text-white/90 hidden sm:block">
                        <span>{{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</span>
                        <span class="mx-2">·</span>
                        <span>{{ $u['correo'] ?? '' }}</span>
                    </div>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 rounded text-sm">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
