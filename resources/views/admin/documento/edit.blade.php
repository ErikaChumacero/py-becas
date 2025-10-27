<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-3xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Validar Documento</h2>

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

        <!-- Información del Documento (Solo lectura) -->
        <div class="mb-6 p-4 bg-gray-50 rounded border">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Información del Documento</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">ID</label>
                    <p class="mt-1 text-gray-900">{{ $row->iddocumento }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Tipo de documento</label>
                    <p class="mt-1 text-gray-900">{{ $row->tipodocumento }}</p>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600">Archivo</label>
                    <a href="{{ $row->rutaarchivo }}" target="_blank" class="mt-1 text-blue-600 hover:underline inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Ver documento PDF
                    </a>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Postulación</label>
                    <p class="mt-1 text-gray-900">
                        @foreach($postulaciones as $p)
                            @if($p->idpostulacion == $row->idpostulacion)
                                #{{ $p->idpostulacion }} - {{ $p->etiqueta }}
                            @endif
                        @endforeach
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Requisito</label>
                    <p class="mt-1 text-gray-900">
                        @foreach($requisitos as $r)
                            @if($r->idrequisito == $row->idrequisito)
                                {{ $r->descripcion }}
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulario de Validación (Solo cambiar estado) -->
        <form method="POST" action="{{ route('admin.documento.update', $row->iddocumento) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Campos ocultos para mantener los valores originales -->
            <input type="hidden" name="tipodocumento" value="{{ $row->tipodocumento }}">
            <input type="hidden" name="idpostulacion" value="{{ $row->idpostulacion }}">
            <input type="hidden" name="idrequisito" value="{{ $row->idrequisito }}">

            <div class="p-4 bg-blue-50 rounded border border-blue-200">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Estado de Validación</label>
                <select name="validado" class="mt-1 block w-full p-3 border-2 rounded-lg text-lg" required>
                    <option value="1" {{ old('validado', $row->validado)==='1' ? 'selected' : '' }}>Validado</option>
                    <option value="0" {{ old('validado', $row->validado)==='0' ? 'selected' : '' }}>No validado</option>
                </select>
                <p class="mt-2 text-sm text-gray-600">
                    <strong>Nota:</strong> Al validar un documento, el estudiante podrá ver que su documento fue aprobado.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.documento.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded font-semibold">Guardar Estado</button>
            </div>
        </form>
    </div>
</x-admin-layout>
