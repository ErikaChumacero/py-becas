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
        <h1 class="text-xl font-semibold">Documentos</h1>
        <a href="{{ route('admin.documento.create') }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-500 text-white">Nuevo documento</a>
    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="text-left p-2 border-b">ID</th>
                <th class="text-left p-2 border-b">Tipo</th>
                <th class="text-left p-2 border-b">Archivo</th>
                <th class="text-left p-2 border-b">Postulación</th>
                <th class="text-left p-2 border-b">Estudiante</th>
                <th class="text-left p-2 border-b">Convocatoria</th>
                <th class="text-left p-2 border-b">Requisito</th>
                <th class="text-left p-2 border-b">Estado</th>
                <th class="text-left p-2 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $d)
                <tr class="border-t">
                    <td class="p-2">{{ $d->iddocumento }}</td>
                    <td class="p-2">{{ $d->tipodocumento }}</td>
                    <td class="p-2 truncate max-w-[240px]"><a href="{{ $d->rutaarchivo }}" target="_blank" class="text-blue-600 hover:underline">{{ $d->rutaarchivo }}</a></td>
                    <td class="p-2">#{{ $d->idpostulacion }}</td>
                    <td class="p-2">{{ $d->estudiante }} ({{ $d->ci }})</td>
                    <td class="p-2">{{ $d->convocatoria }}</td>
                    <td class="p-2">{{ $d->requisito }}</td>
                    <td class="p-2">
                        <span class="px-2 py-0.5 rounded text-xs {{ $d->validado==='1' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                            {{ $d->validado === '1' ? 'Validado' : 'No validado' }}
                        </span>
                    </td>
                    <td class="p-2 space-x-2">
                        <a href="{{ route('admin.documento.edit', $d->iddocumento) }}" class="px-2 py-1 rounded bg-amber-500 hover:bg-amber-400 text-white">Editar</a>
                        @if($d->validado==='1')
                        <form action="{{ route('admin.documento.disable', $d->iddocumento) }}" method="POST" class="inline">
                            @csrf
                            <button onclick="return confirm('¿Marcar como no validado este documento?');" class="px-2 py-1 rounded bg-rose-600 hover:bg-rose-500 text-white">Deshabilitar</button>
                        </form>
                        @endif
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
