<x-student-layout>
    @includeIf('layouts.partials.gheader')

    @if (session('status'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Convocatorias abiertas</h1>
    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="text-left p-2 border-b">ID</th>
                <th class="text-left p-2 border-b">Título</th>
                <th class="text-left p-2 border-b">Tipo de Beca</th>
                <th class="text-left p-2 border-b">Inicio</th>
                <th class="text-left p-2 border-b">Fin</th>
                <th class="text-left p-2 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $c)
                <tr class="border-t">
                    <td class="p-2">{{ $c->idconvocatoria }}</td>
                    <td class="p-2">{{ $c->titulo }}</td>
                    <td class="p-2">{{ $c->tipobeca }}</td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($c->fechainicio)->format('Y-m-d') }}</td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($c->fechafin)->format('Y-m-d') }}</td>
                    <td class="p-2">
                        <a class="px-2 py-1 rounded bg-blue-600 hover:bg-blue-500 text-white" href="{{ route('estudiante.convocatoria.show', $c->idconvocatoria) }}">Ver</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-3 text-center text-gray-500">Sin convocatorias abiertas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-student-layout>
