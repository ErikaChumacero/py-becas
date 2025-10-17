<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Nuevo Documento</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.documento.store') }}" class="space-y-4" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Postulación</label>
                    <select name="idpostulacion" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="">Seleccione...</option>
                        @foreach($postulaciones as $p)
                        <option value="{{ $p->idpostulacion }}" {{ old('idpostulacion')==$p->idpostulacion ? 'selected' : '' }}>
                            #{{ $p->idpostulacion }} - {{ $p->etiqueta }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Requisito</label>
                    <select name="idrequisito" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="">Seleccione...</option>
                        @foreach($requisitos as $r)
                        <option value="{{ $r->idrequisito }}" {{ old('idrequisito')==$r->idrequisito ? 'selected' : '' }}>{{ $r->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Tipo de documento</label>
                    <input type="text" name="tipodocumento" value="{{ old('tipodocumento') }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Archivo (PDF)</label>
                    <input type="file" name="archivo" accept="application/pdf" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Estado</label>
                    <select name="validado" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="1" {{ old('validado','1')==='1' ? 'selected' : '' }}>Validado</option>
                        <option value="0" {{ old('validado')==='0' ? 'selected' : '' }}>No validado</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.documento.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-admin-layout>
