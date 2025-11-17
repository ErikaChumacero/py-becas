<x-secretaria-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Gestión de Becas</h1>
                    <p class="text-green-100 text-lg">Control y asignación de becas estudiantiles</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('secretaria.beca.automaticas') }}" class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-yellow-600 transition-colors shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Becas Automáticas
                    </a>
                    <a href="{{ route('secretaria.beca.create') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Asignar Beca
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-600">
                <p class="text-sm text-gray-600 font-medium uppercase tracking-wide">Total Becas</p>
                <p class="text-4xl font-bold text-gray-900 mt-3">{{ $totalBecas }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-600">
                <p class="text-sm text-gray-600 font-medium uppercase tracking-wide">Becas 100%</p>
                <p class="text-4xl font-bold text-yellow-600 mt-3">{{ $totalBecas100 }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-600">
                <p class="text-sm text-gray-600 font-medium uppercase tracking-wide">Promedio Descuento</p>
                <p class="text-4xl font-bold text-green-600 mt-3">{{ number_format($promedioDescuento, 1) }}%</p>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtros
            </h2>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('secretaria.beca.index') }}" 
                   class="px-4 py-2 rounded-lg font-medium transition-colors {{ !$gestion && !$tipo ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Todas
                </a>
                
                @foreach($gestiones as $g)
                    <a href="{{ route('secretaria.beca.index', ['gestion' => $g->gestion]) }}" 
                       class="px-4 py-2 rounded-lg font-medium transition-colors {{ $gestion == $g->gestion ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $g->gestion }}
                    </a>
                @endforeach

                <div class="border-l border-gray-300 mx-2"></div>

                <a href="{{ route('secretaria.beca.index', ['tipo' => '1']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition-colors {{ $tipo == '1' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Mérito Académico
                </a>
                
                <a href="{{ route('secretaria.beca.index', ['tipo' => '2']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition-colors {{ $tipo == '2' ? 'bg-orange-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Familiar
                </a>

                <a href="{{ route('secretaria.beca.index', ['tipo' => '3']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition-colors {{ $tipo == '3' ? 'bg-teal-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Económica
                </a>
            </div>
        </div>

        <!-- Tabla de Becas -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                    Listado de Becas ({{ count($becas) }})
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Beca</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Porcentaje</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gestión</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel/Curso</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($becas as $beca)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-mono text-gray-900">#{{ $beca->codbeca }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($beca->estudiante_nombre, 0, 1) }}{{ substr($beca->estudiante_apellido, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $beca->estudiante_nombre }} {{ $beca->estudiante_apellido }}</div>
                                            <div class="text-xs text-gray-500">{{ $beca->codestudiante }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-gray-900">{{ $beca->nombrebeca }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $beca->tipobeca == '1' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $beca->tipobeca == '2' ? 'bg-orange-100 text-orange-800' : '' }}
                                        {{ $beca->tipobeca == '3' ? 'bg-teal-100 text-teal-800' : '' }}">
                                        {{ $beca->tipo_beca_texto }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-2xl font-bold {{ $beca->porcentaje == 100 ? 'text-yellow-600' : 'text-green-600' }}">
                                        {{ $beca->porcentaje }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $beca->gestion }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $beca->nivel }}</div>
                                    <div class="text-xs text-gray-500">{{ $beca->curso }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('secretaria.beca.show', $beca->codbeca) }}" 
                                           class="text-blue-600 hover:text-blue-800 transition-colors" title="Ver detalle">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('secretaria.beca.quitar') }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de quitar esta beca?')">
                                            @csrf
                                            <input type="hidden" name="ci" value="{{ $beca->ci }}">
                                            <input type="hidden" name="idcurso" value="{{ $beca->idcurso ?? 0 }}">
                                            <input type="hidden" name="idnivel" value="{{ $beca->idnivel ?? 0 }}">
                                            <input type="hidden" name="idgestion" value="{{ $beca->idgestion ?? 0 }}">
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Quitar beca">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No hay becas registradas</p>
                                        <p class="text-sm mt-2">Comienza asignando la primera beca</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(session('success'))
        <script>
            setTimeout(() => {
                alert('{{ session('success') }}');
            }, 100);
        </script>
    @endif

    @if(session('error'))
        <script>
            setTimeout(() => {
                alert('{{ session('error') }}');
            }, 100);
        </script>
    @endif
</x-secretaria-layout>
