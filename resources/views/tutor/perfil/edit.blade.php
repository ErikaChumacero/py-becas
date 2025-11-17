<x-tutor-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Editar Perfil</h1>
                    <p class="text-green-100 text-lg">Actualiza tu información personal</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-20 h-20 text-green-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Mensajes de Error -->
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-red-700 font-medium mb-2">Por favor corrige los siguientes errores:</p>
                        <ul class="list-disc list-inside text-red-600 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <form action="{{ route('tutor.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- CI (Solo lectura) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">CI</label>
                        <input type="text" value="{{ $tutor->ci }}" disabled class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">El CI no puede ser modificado</p>
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $tutor->nombre) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('nombre') border-red-500 @enderror">
                        @error('nombre')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellido -->
                    <div>
                        <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-2">
                            Apellido <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $tutor->apellido) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('apellido') border-red-500 @enderror">
                        @error('apellido')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Correo -->
                    <div>
                        <label for="correo" class="block text-sm font-semibold text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <input type="email" id="correo" name="correo" value="{{ old('correo', $tutor->correo) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('correo') border-red-500 @enderror">
                        @error('correo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-2">
                            Teléfono
                        </label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $tutor->telefono) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('telefono') border-red-500 @enderror">
                        @error('telefono')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sexo -->
                    <div>
                        <label for="sexo" class="block text-sm font-semibold text-gray-700 mb-2">
                            Sexo <span class="text-red-500">*</span>
                        </label>
                        <select id="sexo" name="sexo" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('sexo') border-red-500 @enderror">
                            <option value="M" {{ old('sexo', $tutor->sexo) === 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('sexo', $tutor->sexo) === 'F' ? 'selected' : '' }}>Femenino</option>
                        </select>
                        @error('sexo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('tutor.perfil.index') }}" 
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Cancelar
                    </a>
                    <button type="submit" 
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-tutor-layout>
