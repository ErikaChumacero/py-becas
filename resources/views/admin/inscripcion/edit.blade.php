<x-admin-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.inscripcion.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Inscripción</h1>
                <p class="text-gray-600 mt-1">Modifica los datos de la inscripción</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.inscripcion.update', [$inscripcion->ci, $inscripcion->idcurso, $inscripcion->idnivel]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información de la Inscripción (Solo lectura) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Información de la Inscripción</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Estudiante</p>
                            <p class="text-sm font-bold text-gray-900">{{ $inscripcion->estudiante_nombre }}</p>
                            <p class="text-xs text-gray-600">CI: {{ $inscripcion->ci }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Nivel</p>
                            <p class="text-sm font-bold text-indigo-900">{{ $inscripcion->nivel_nombre }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Curso</p>
                            <p class="text-sm font-bold text-gray-900">{{ $inscripcion->curso_nombre }}</p>
                        </div>
                    </div>
                    <div class="mt-4 bg-amber-50 border-l-4 border-amber-500 p-3 rounded-r">
                        <p class="text-xs text-amber-700">
                            <strong>Nota:</strong> No se puede cambiar el estudiante, nivel o curso de una inscripción existente. 
                            Si necesita hacer estos cambios, debe eliminar esta inscripción y crear una nueva.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tutor -->
                    <div>
                        <label for="citutor" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tutor <span class="text-red-500">*</span>
                        </label>
                        <select name="citutor" id="citutor" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('citutor') border-red-500 @enderror">
                            <option value="">Seleccione un tutor</option>
                            @foreach($tutores as $tutor)
                                <option value="{{ $tutor->ci }}" {{ old('citutor', $inscripcion->citutor) == $tutor->ci ? 'selected' : '' }}>
                                    {{ $tutor->apellido }} {{ $tutor->nombre }} ({{ $tutor->ci }})
                                </option>
                            @endforeach
                        </select>
                        @error('citutor')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gestión -->
                    <div>
                        <label for="idgestion" class="block text-sm font-semibold text-gray-700 mb-2">
                            Gestión <span class="text-red-500">*</span>
                        </label>
                        <select name="idgestion" id="idgestion" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('idgestion') border-red-500 @enderror">
                            <option value="">Seleccione una gestión</option>
                            @foreach($gestiones as $gestion)
                                <option value="{{ $gestion->idgestion }}" {{ old('idgestion', $inscripcion->idgestion) == $gestion->idgestion ? 'selected' : '' }}>
                                    {{ $gestion->detalleges }}
                                </option>
                            @endforeach
                        </select>
                        @error('idgestion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Registro -->
                    <div>
                        <label for="fecharegis" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha de Registro <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecharegis" id="fecharegis" 
                               value="{{ old('fecharegis', $inscripcion->fecharegis) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('fecharegis') border-red-500 @enderror">
                        @error('fecharegis')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Beca (opcional) -->
                    <div>
                        <label for="codbeca" class="block text-sm font-semibold text-gray-700 mb-2">
                            Beca (opcional)
                        </label>
                        <select name="codbeca" id="codbeca"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('codbeca') border-red-500 @enderror">
                            <option value="">Sin beca</option>
                            @foreach($becas as $beca)
                                <option value="{{ $beca->codbeca }}" {{ old('codbeca', $inscripcion->codbeca) == $beca->codbeca ? 'selected' : '' }}>
                                    {{ $beca->nombrebeca }} - {{ $beca->porcentaje }}% ({{ $beca->tipobeca }})
                                </option>
                            @endforeach
                        </select>
                        @error('codbeca')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Seleccione una beca o deje "Sin beca"</p>
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <label for="observaciones" class="block text-sm font-semibold text-gray-700 mb-2">
                        Observaciones (opcional)
                    </label>
                    <textarea name="observaciones" id="observaciones" rows="3"
                              placeholder="Si se deja vacío, se asignará 'Inscripción Regular' automáticamente"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('observaciones') border-red-500 @enderror">{{ old('observaciones', $inscripcion->observaciones) }}</textarea>
                    @error('observaciones')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 200 caracteres.</p>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.inscripcion.index') }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Actualizar Inscripción
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
