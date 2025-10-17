<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Editar Documento</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.documento.update', $row->iddocumento) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">ID</label>
                    <input type="text" value="{{ $row->iddocumento }}" class="mt-1 block w-full p-2 border rounded bg-gray-100" disabled>
                </div>
                <div>
                    <label class="block text-gray-700">Tipo de documento</label>
                    <input type="text" name="tipodocumento" value="{{ old('tipodocumento', $row->tipodocumento) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-gray-700">Ruta del archivo</label>
                    <input type="text" name="rutaarchivo" value="{{ old('rutaarchivo', $row->rutaarchivo) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Estado</label>
                    <select name="validado" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="1" {{ old('validado', $row->validado)==='1' ? 'selected' : '' }}>Validado</option>
                        <option value="0" {{ old('validado', $row->validado)==='0' ? 'selected' : '' }}>No validado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Postulación</label>
                    <select name="idpostulacion" class="mt-1 block w-full p-2 border rounded" required>
                        @foreach($postulaciones as $p)
                        <option value="{{ $p->idpostulacion }}" {{ old('idpostulacion', $row->idpostulacion)==$p->idpostulacion ? 'selected' : '' }}>
                            #{{ $p->idpostulacion }} - {{ $p->etiqueta }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Requisito</label>
                    <select name="idrequisito" class="mt-1 block w-full p-2 border rounded" required>
                        @foreach($requisitos as $r)
                        <option value="{{ $r->idrequisito }}" {{ old('idrequisito', $row->idrequisito)==$r->idrequisito ? 'selected' : '' }}>{{ $r->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.documento.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Actualizar</button>
            </div>
        </form>

        <div class="mt-6">
            <form action="{{ route('admin.documento.disable', $row->iddocumento) }}" method="POST" onsubmit="return confirm('¿Marcar como no validado este documento?');">
                @csrf
                <button class="px-3 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded">Deshabilitar documento</button>
            </form>
        </div>
    </div>
</x-admin-layout>
