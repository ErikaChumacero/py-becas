<x-admin-layout>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Carreras</h1>
        <a href="{{ route('admin.carrera.create') }}" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Nueva Carrera</a>
    </div>

    @if (session('status'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
    @endif

    <div class="overflow-x-auto border rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Plan</th>
                    <th class="p-2 text-left">Código</th>
                    <th class="p-2 text-left">Nombre</th>
                    <th class="p-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $r)
                    <tr class="border-t">
                        <td class="p-2">{{ $r->idcarrera }}</td>
                        <td class="p-2">{{ $r->plancarrera }}</td>
                        <td class="p-2">{{ $r->codigo }}</td>
                        <td class="p-2">{{ $r->nombre }}</td>
                        <td class="p-2 space-x-2">
                            <a class="px-2 py-1 bg-amber-500 hover:bg-amber-400 text-white rounded" href="{{ route('admin.carrera.edit', $r->idcarrera) }}">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="5">Sin registros</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>

