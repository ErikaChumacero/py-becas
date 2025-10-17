<x-student-layout>
    @includeIf('layouts.partials.gheader')

    <div class="max-w-3xl p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-1">{{ $row->titulo }}</h1>
        <div class="text-gray-600 mb-4">Tipo de Beca: <span class="font-medium">{{ $row->tipobeca }}</span></div>
        <div class="prose max-w-none mb-4">
            <p>{{ $row->descripcion }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div>
                <div class="text-xs text-gray-500">Fecha inicio</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($row->fechainicio)->format('Y-m-d') }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-500">Fecha fin</div>
                <div class="font-medium">{{ \Carbon\Carbon::parse($row->fechafin)->format('Y-m-d') }}</div>
            </div>
        </div>

        <h2 class="text-xl font-semibold mb-2">Requisitos</h2>
        <ul class="list-disc list-inside mb-6">
            @forelse($requisitos as $r)
                <li>
                    {{ $r->descripcion }}
                    @if($r->obligatorio==='1')
                        <span class="ml-2 px-2 py-0.5 rounded text-xs bg-amber-100 text-amber-800">Obligatorio</span>
                    @endif
                </li>
            @empty
                <li class="text-gray-500">Sin requisitos configurados</li>
            @endforelse
        </ul>

        <div class="flex items-center gap-2">
            <a href="{{ route('estudiante.convocatoria.index') }}" class="px-3 py-2 bg-gray-200 rounded">Volver</a>
            <a href="{{ route('estudiante.postulacion.create') }}" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Postular</a>
        </div>
    </div>
</x-student-layout>
