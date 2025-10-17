<x-student-layout>
    @includeIf('layouts.partials.gheader')

    <div class="w-full max-w-2xl p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Editar Postulación</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-rose-100 text-rose-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('estudiante.postulacion.update', $row->idpostulacion) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">ID</label>
                    <input type="text" value="{{ $row->idpostulacion }}" class="mt-1 block w-full p-2 border rounded bg-gray-100" disabled>
                </div>
                <div>
                    <label class="block text-gray-700">Fecha de postulación</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($row->fechapostulacion)->format('Y-m-d') }}" class="mt-1 block w-full p-2 border rounded bg-gray-100" disabled>
                </div>
                <div>
                    <label class="block text-gray-700">Convocatoria</label>
                    <select name="idconvocatoria" class="mt-1 block w-full p-2 border rounded" required>
                        @foreach($convocatorias as $c)
                        <option value="{{ $c->idconvocatoria }}" {{ old('idconvocatoria', $row->idconvocatoria)==$c->idconvocatoria ? 'selected' : '' }}>{{ $c->titulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Carrera</label>
                    <select name="idcarrera" class="mt-1 block w-full p-2 border rounded" required>
                        @foreach($carreras as $c)
                        <option value="{{ $c->idcarrera }}" {{ old('idcarrera', $row->idcarrera)==$c->idcarrera ? 'selected' : '' }}>{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Semestre</label>
                    <select name="idsemestre" class="mt-1 block w-full p-2 border rounded" required>
                        @foreach($semestres as $s)
                        <option value="{{ $s->idsemestre }}" {{ old('idsemestre', $row->idsemestre)==$s->idsemestre ? 'selected' : '' }}>{{ $s->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('estudiante.postulacion.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Actualizar</button>
            </div>
        </form>

        <div class="mt-6">
            <form action="{{ route('estudiante.postulacion.cancel', $row->idpostulacion) }}" method="POST" onsubmit="return confirm('¿Cancelar esta postulación?');">
                @csrf
                <button class="px-3 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded">Cancelar postulación</button>
            </form>
        </div>
    </div>
</x-student-layout>
