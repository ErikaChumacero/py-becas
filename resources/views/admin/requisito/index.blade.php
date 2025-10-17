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
        <h1 class="text-xl font-semibold">Requisitos</h1>
        <a href="{{ route('admin.requisito.create') }}" class="px-3 py-2 rounded bg-blue-600 hover:bg-blue-500 text-white">Nuevo requisito</a>
    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="text-left p-2 border-b">ID</th>
                <th class="text-left p-2 border-b">Descripción</th>
                <th class="text-left p-2 border-b">Tipo de Beca</th>
                <th class="text-left p-2 border-b">Obligatorio</th>
                <th class="text-left p-2 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $r)
                <tr class="border-t">
                    <td class="p-2">{{ $r->idrequisito }}</td>
                    <td class="p-2">{{ $r->descripcion }}</td>
                    <td class="p-2">{{ $r->tipobeca }}</td>
                    <td class="p-2">
                        <span class="px-2 py-0.5 rounded text-xs {{ $r->obligatorio==='1' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                            {{ $r->obligatorio==='1' ? 'Sí' : 'No' }}
                        </span>
                    </td>
                    <td class="p-2 space-x-2">
                        <a class="px-2 py-1 rounded bg-amber-500 hover:bg-amber-400 text-white" href="{{ route('admin.requisito.edit', $r->idrequisito) }}">Editar</a>
                        @if($r->obligatorio==='1')
                        <form action="{{ route('admin.requisito.disable', $r->idrequisito) }}" method="POST" class="inline">
                            @csrf
                            <button onclick="return confirm('¿Deshabilitar este requisito?');" class="px-2 py-1 rounded bg-rose-600 hover:bg-rose-500 text-white">Deshabilitar</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-3 text-center text-gray-500">Sin registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-admin-layout>
