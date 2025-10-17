<x-admin-layout>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Convocatorias</h1>
        <a href="{{ route('admin.convocatoria.create') }}" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Nueva Convocatoria</a>
    </div>

    @if (session('status'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
    @endif

    @error('general')
        <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">{{ $message }}</div>
    @enderror

    <div class="overflow-x-auto border rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Título</th>
                    <th class="p-2 text-left">Tipo de Beca</th>
                    <th class="p-2 text-left">Inicio</th>
                    <th class="p-2 text-left">Fin</th>
                    <th class="p-2 text-left">Estado</th>
                    <th class="p-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $c)
                    <tr class="border-t">
                        <td class="p-2">{{ $c->idconvocatoria }}</td>
                        <td class="p-2">{{ $c->titulo }}</td>
                        <td class="p-2">{{ $c->tipobeca_nombre }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($c->fechainicio)->format('Y-m-d') }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($c->fechafin)->format('Y-m-d') }}</td>
                        <td class="p-2">
                            <span class="px-2 py-0.5 rounded text-xs {{ $c->estado==='1' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                                {{ $c->estado === '1' ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td class="p-2 space-x-2">
                            <a class="px-2 py-1 bg-amber-500 hover:bg-amber-400 text-white rounded" href="{{ route('admin.convocatoria.edit', $c->idconvocatoria) }}">Editar</a>
                            @if($c->estado==='1')
                            <form action="{{ route('admin.convocatoria.disable', $c->idconvocatoria) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-2 py-1 bg-rose-600 hover:bg-rose-500 text-white rounded" onclick="return confirm('¿Deshabilitar esta convocatoria?');">Deshabilitar</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="7">Sin registros</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
