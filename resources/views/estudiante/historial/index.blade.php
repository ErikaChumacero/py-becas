<x-student-layout>
    @includeIf('layouts.partials.gheader')

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Historial de Estados</h1>
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
                <th class="text-left p-2 border-b">Convocatoria</th>
                <th class="text-left p-2 border-b">Estado Anterior</th>
                <th class="text-left p-2 border-b">Estado Nuevo</th>
                <th class="text-left p-2 border-b">Fecha</th>
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
                    <td class="p-2">{{ $h->convocatoria }}</td>
                    <td class="p-2"><span class="px-2 py-0.5 rounded text-xs {{ $anterior[1] }}">{{ $anterior[0] }}</span></td>
                    <td class="p-2"><span class="px-2 py-0.5 rounded text-xs {{ $nuevo[1] }}">{{ $nuevo[0] }}</span></td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($h->fechacambio)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-3 text-center text-gray-500">Sin registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-student-layout>
