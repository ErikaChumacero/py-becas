<x-student-layout>
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
        <h1 class="text-xl font-semibold">Mis postulaciones</h1>
        <a href="{{ route('estudiante.postulacion.create') }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-500 text-white">Nueva postulación</a>
    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="text-left p-2 border-b">ID</th>
                <th class="text-left p-2 border-b">Convocatoria</th>
                <th class="text-left p-2 border-b">Carrera</th>
                <th class="text-left p-2 border-b">Semestre</th>
                <th class="text-left p-2 border-b">Fecha</th>
                <th class="text-left p-2 border-b">Estado</th>
                <th class="text-left p-2 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $p)
                <tr class="border-t">
                    <td class="p-2">{{ $p->idpostulacion }}</td>
                    <td class="p-2">{{ $p->convocatoria }}</td>
                    <td class="p-2">{{ $p->carrera }}</td>
                    <td class="p-2">{{ $p->semestre }}</td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($p->fechapostulacion)->format('Y-m-d') }}</td>
                    <td class="p-2">
                        @php
                            $labels = ['1' => 'En revisión', '2' => 'Pendiente', '3' => 'Aprobada', '4' => 'Rechazada'];
                            $classes = [
                                '1' => 'bg-amber-100 text-amber-800',
                                '2' => 'bg-gray-100 text-gray-800',
                                '3' => 'bg-green-100 text-green-800',
                                '4' => 'bg-rose-100 text-rose-800',
                            ];
                            $e = strval($p->estado);
                        @endphp
                        <span class="px-2 py-0.5 rounded {{ $classes[$e] ?? 'bg-gray-100 text-gray-800' }}">{{ $labels[$e] ?? $p->estado }}</span>
                    </td>
                    <td class="p-2 space-x-2">
                        <a class="px-2 py-1 rounded bg-amber-500 hover:bg-amber-400 text-white" href="{{ route('estudiante.postulacion.edit', $p->idpostulacion) }}">Editar</a>
                        <form action="{{ route('estudiante.postulacion.cancel', $p->idpostulacion) }}" method="POST" class="inline">
                            @csrf
                            <button onclick="return confirm('¿Cancelar esta postulación?');" class="px-2 py-1 rounded bg-rose-600 hover:bg-rose-500 text-white">Cancelar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-3 text-center text-gray-500">Sin postulaciones</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-student-layout>
