<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    @if (session('status'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
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
        <h1 class="text-xl font-semibold">Historial de Estados</h1>
        <a href="{{ route('admin.historial.create') }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-500 text-white">Nuevo registro</a>
    </div>

    <div class="mb-4 text-sm">
        <span class="mr-2">Leyenda:</span>
        <span class="inline-block px-2 py-0.5 rounded mr-2 bg-amber-100 text-amber-800">En revisión</span>
        <span class="inline-block px-2 py-0.5 rounded mr-2 bg-gray-200 text-gray-800">Pendiente</span>
        <span class="inline-block px-2 py-0.5 rounded mr-2 bg-green-100 text-green-800">Aprobada</span>
        <span class="inline-block px-2 py-0.5 rounded mr-2 bg-rose-100 text-rose-800">Rechazada</span>
    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="text-left p-2 border-b">ID</th>
                <th class="text-left p-2 border-b">Postulación</th>
                <th class="text-left p-2 border-b">Estudiante</th>
                <th class="text-left p-2 border-b">Convocatoria</th>
                <th class="text-left p-2 border-b">Estado Anterior</th>
                <th class="text-left p-2 border-b">Estado Nuevo</th>
                <th class="text-left p-2 border-b">Fecha</th>
                <th class="text-left p-2 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $h)
                @php
                    $labels = [
                        '1' => ['En revisión','bg-amber-100 text-amber-800'],
                        '2' => ['Pendiente','bg-gray-200 text-gray-800'],
                        '3' => ['Aprobada','bg-green-100 text-green-800'],
                        '4' => ['Rechazada','bg-rose-100 text-rose-800'],
                    ];
                    $anterior = $labels[(string)$h->estadoanterior] ?? [$h->estadoanterior,'bg-gray-200 text-gray-800'];
                    $nuevo = $labels[(string)$h->estadonuevo] ?? [$h->estadonuevo,'bg-gray-200 text-gray-800'];
                @endphp
                <tr class="border-t">
                    <td class="p-2">{{ $h->idhistorialestado }}</td>
                    <td class="p-2">#{{ $h->idpostulacion }}</td>
                    <td class="p-2">{{ $h->estudiante }}</td>
                    <td class="p-2">{{ $h->convocatoria }}</td>
                    <td class="p-2"><span class="px-2 py-0.5 rounded text-xs {{ $anterior[1] }}">{{ $anterior[0] }}</span></td>
                    <td class="p-2"><span class="px-2 py-0.5 rounded text-xs {{ $nuevo[1] }}">{{ $nuevo[0] }}</span></td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($h->fechacambio)->format('Y-m-d') }}</td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('admin.historial.edit', $h->idhistorialestado) }}" class="px-2 py-1 rounded bg-amber-500 hover:bg-amber-400 text-white">Editar</a>
                        @if($h->estadonuevo !== '0')
                        <form action="{{ route('admin.historial.disable', $h->idhistorialestado) }}" method="POST" class="inline">
                            @csrf
                            <button onclick="return confirm('¿Deshabilitar este historial (estado nuevo a 0)?');" class="px-2 py-1 rounded bg-rose-600 hover:bg-rose-500 text-white">Deshabilitar</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-3 text-center text-gray-500">Sin registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-admin-layout>
