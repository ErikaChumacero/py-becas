<x-admin-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Nueva Postulación</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.postulacion.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Estudiante</label>
                    <select name="ci" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="">Seleccione...</option>
                        @foreach($personas as $p)
                        <option value="{{ $p->ci }}" {{ old('ci')===$p->ci ? 'selected' : '' }}>{{ $p->nombre }} ({{ $p->ci }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Convocatoria</label>
                    <select name="idconvocatoria" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="">Seleccione...</option>
                        @foreach($convocatorias as $c)
                        <option value="{{ $c->idconvocatoria }}" {{ old('idconvocatoria')==$c->idconvocatoria ? 'selected' : '' }}>{{ $c->titulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Carrera</label>
                    <select name="idcarrera" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="">Seleccione...</option>
                        @foreach($carreras as $c)
                        <option value="{{ $c->idcarrera }}" {{ old('idcarrera')==$c->idcarrera ? 'selected' : '' }}>{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Semestre</label>
                    <select name="idsemestre" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="">Seleccione...</option>
                        @foreach($semestres as $s)
                        <option value="{{ $s->idsemestre }}" {{ old('idsemestre')==$s->idsemestre ? 'selected' : '' }}>{{ $s->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Fecha de postulación</label>
                    <input type="date" name="fechapostulacion" value="{{ old('fechapostulacion', now()->format('Y-m-d')) }}" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Estado</label>
                    <select name="estado" class="mt-1 block w-full p-2 border rounded" required>
                        <option value="1" {{ old('estado','1')==='1' ? 'selected' : '' }}>En revisión</option>
                        <option value="2" {{ old('estado')==='2' ? 'selected' : '' }}>Pendiente</option>
                        <option value="3" {{ old('estado')==='3' ? 'selected' : '' }}>Aprobada</option>
                        <option value="4" {{ old('estado')==='4' ? 'selected' : '' }}>Rechazada</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.postulacion.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-admin-layout>
