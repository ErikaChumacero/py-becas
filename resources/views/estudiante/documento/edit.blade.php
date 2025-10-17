<x-student-layout>
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

        <form method="POST" action="{{ route('estudiante.documento.update', $row->iddocumento) }}" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">ID</label>
                    <input type="text" value="{{ $row->iddocumento }}" class="mt-1 block w-full p-2 border rounded bg-gray-100" disabled>
                </div>
                <div>
                    <label class="block text-gray-700">Estado</label>
                    <input type="text" value="{{ $row->validado === '1' ? 'Validado' : 'No validado' }}" class="mt-1 block w-full p-2 border rounded bg-gray-100" disabled>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-gray-700">Archivo actual</label>
                    <a href="{{ $row->rutaarchivo }}" class="text-blue-600 hover:underline" target="_blank">Ver PDF</a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Postulación</label>
                    <select id="idpostulacion" name="idpostulacion" class="mt-1 block w-full p-2 border rounded" required>
                        @foreach($postulaciones as $p)
                        <option value="{{ $p->idpostulacion }}" {{ old('idpostulacion', $row->idpostulacion)==$p->idpostulacion ? 'selected' : '' }}>
                            #{{ $p->idpostulacion }} - {{ $p->etiqueta ?? $p->idpostulacion }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Requisito</label>
                    <select id="idrequisito" name="idrequisito" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="">Cargando...</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Tipo de documento</label>
                    <input type="text" name="tipodocumento" value="{{ old('tipodocumento', $row->tipodocumento) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-gray-700">Reemplazar archivo (PDF)</label>
                    <input type="file" name="archivo" accept="application/pdf" class="mt-1 block w-full p-2 border rounded">
                    <p class="text-xs text-gray-500 mt-1">Opcional. Dejar vacío para conservar el archivo actual.</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('estudiante.documento.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Actualizar</button>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const selPost = document.getElementById('idpostulacion');
                const selReq = document.getElementById('idrequisito');
                const selectedReq = "{{ old('idrequisito', $row->idrequisito) }}";
                async function cargarRequisitos(idpostulacion) {
                    if (!idpostulacion) { selReq.innerHTML = '<option value="">Seleccione...</option>'; return; }
                    try {
                        const res = await fetch(`/estudiante/documento/requisitos/${idpostulacion}`);
                        const data = await res.json();
                        selReq.innerHTML = '';
                        data.forEach(r => {
                            const opt = document.createElement('option');
                            opt.value = r.idrequisito;
                            opt.textContent = r.descripcion + (r.obligatorio === '1' ? ' (Obligatorio)' : '');
                            if (selectedReq && selectedReq == r.idrequisito) opt.selected = true;
                            selReq.appendChild(opt);
                        });
                        if (!selReq.value) selReq.insertAdjacentHTML('afterbegin','<option value="">Seleccione...</option>');
                    } catch (e) {
                        selReq.innerHTML = '<option value="">Error al cargar</option>';
                    }
                }
                selPost.addEventListener('change', e => cargarRequisitos(e.target.value));
                if (selPost.value) cargarRequisitos(selPost.value);
            });
        </script>

        <div class="mt-6">
            <form action="{{ route('estudiante.documento.disable', $row->iddocumento) }}" method="POST" onsubmit="return confirm('¿Deshabilitar este documento?');">
                @csrf
                <button class="px-3 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded">Deshabilitar documento</button>
            </form>
        </div>
    </div>
</x-student-layout>
