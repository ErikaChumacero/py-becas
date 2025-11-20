<nav id="header-nav" class="fixed top-0 left-56 right-0 z-30 bg-blue-900 border-b border-blue-900 text-white h-16 transition-all duration-300">
  <div class="px-3 py-3 lg:px-5 lg:pl-3 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-white/90 rounded-lg sm:hidden hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75Zm0 10.5a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd"/></svg>
      </button>
      <a href="{{ route('estudiante.dashboard') }}" class="flex ml-2 md:mr-24 items-center gap-2">
        <i class="fa-solid fa-user-graduate text-white"></i>
        <span class="self-center text-xl font-semibold whitespace-nowrap text-white">Panel Estudiante</span>
      </a>
    </div>
    <div class="flex items-center gap-3">
      @php($u = session('usuario'))
      @if($u)
        <span class="text-sm text-white/90 hidden sm:block">{{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}</span>
      @endif
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="px-3 py-1.5 rounded bg-rose-600 hover:bg-rose-500 text-white text-sm">Cerrar sesión</button>
      </form>
    </div>
  </div>
</nav>
