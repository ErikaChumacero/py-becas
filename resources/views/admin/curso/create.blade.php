<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header con breadcrumb -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.curso.index', $nivel->idnivel) }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.nivel.index') }}" class="hover:text-gray-700">Niveles</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('admin.curso.index', $nivel->idnivel) }}" class="hover:text-gray-700">{{ $nivel->descripcion }}</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-gray-900 font-medium">Nuevo Curso</span>
                </nav>
                <h1 class="text-3xl font-bold text-gray-800">Nuevo Curso</h1>
                <p class="text-gray-600 mt-1">Crea un nuevo curso para {{ $nivel->descripcion }}</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.curso.store', $nivel->idnivel) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nivel (solo lectura) -->
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <div>
                            <p class="text-xs font-medium text-indigo-600 uppercase">Nivel</p>
                            <p class="text-lg font-bold text-indigo-900">{{ $nivel->descripcion }}</p>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">
                        Descripción del Curso <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="descripcion" 
                           id="descripcion" 
                           value="{{ old('descripcion') }}"
                           placeholder="Ej: 1ro A, 2do B, Kinder"
                           maxlength="100"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('descripcion') border-red-500 @enderror"
                           required
                           autofocus>
                    @error('descripcion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 100 caracteres. Debe ser único dentro de este nivel.</p>
                </div>

                <!-- Botones -->
                <div class="flex items-center gap-4 pt-4 border-t">
                    <a href="{{ route('admin.curso.index', $nivel->idnivel) }}"
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        Registrar Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
