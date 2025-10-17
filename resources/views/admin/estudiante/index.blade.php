<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Estudiantes</h1>
        <a href="{{ route('admin.estudiante.create') }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-500 text-white">Nuevo estudiante</a>
    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="text-left p-2 border-b">CI</th>
                <th class="text-left p-2 border-b">Nombre</th>
                <th class="text-left p-2 border-b">Apellido</th>
                <th class="text-left p-2 border-b">Teléfono</th>
                <th class="text-left p-2 border-b">Sexo</th>
                <th class="text-left p-2 border-b">Correo</th>
                <th class="text-left p-2 border-b">Código</th>
                <th class="text-left p-2 border-b">Nro Reg.</th>
                <th class="text-left p-2 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($personas as $p)
                <tr class="border-t">
                    <td class="p-2">{{ $p->ci }}</td>
                    <td class="p-2">{{ $p->nombre }}</td>
                    <td class="p-2">{{ $p->apellido }}</td>
                    <td class="p-2">{{ $p->telefono }}</td>
                    <td class="p-2">{{ $p->sexo }}</td>
                    <td class="p-2">{{ $p->correo }}</td>
                    <td class="p-2">{{ $p->codigo ?? '-' }}</td>
                    <td class="p-2">{{ $p->nroregistro ?? '-' }}</td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('admin.estudiante.edit', $p->ci) }}" class="px-2 py-1 rounded bg-amber-500 hover:bg-amber-400 text-white">Editar</a>
                        <form action="{{ route('admin.estudiante.disable', $p->ci) }}" method="POST" class="inline">
                            @csrf
                            <button onclick="return confirm('¿Deshabilitar este estudiante?');" class="px-2 py-1 rounded bg-rose-600 hover:bg-rose-500 text-white">Deshabilitar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-3 text-center text-gray-500">Sin registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-admin-layout>
