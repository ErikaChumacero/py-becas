<x-student-layout>
    @includeIf('layouts.partials.gheader')

    <div class="p-6 bg-white rounded shadow">
        <h1 class="text-xl font-semibold mb-2">Panel de Estudiante</h1>
        @php($u = session('usuario'))
        @if($u)
            <p class="text-gray-700">Bienvenido/a {{ $u['nombre'] ?? '' }} {{ $u['apellido'] ?? '' }}.</p>
        @else
            <p class="text-gray-700">Bienvenido/a.</p>
        @endif
    </div>
</x-student-layout>
