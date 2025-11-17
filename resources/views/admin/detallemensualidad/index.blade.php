<x-admin-layout>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="container mx-auto mt-5">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Detalle de Mensualidades</h1>
            <a href="{{ route('admin.detallemensualidad.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nuevo Detalle
            </a>
        </div>

        <!-- Filtros -->
        <div class="bg-white p-4 rounded shadow mb-4">
            <form method="GET" action="{{ route('admin.detallemensualidad.index') }}" class="grid grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium mb-1">Gestión</label>
                    <select name="gestion" class="w-full border rounded px-3 py-2">
                        <option value="todos" {{ $filtroGestion == 'todos' ? 'selected' : '' }}>Todas</option>
                        @foreach($gestiones as $gestion)
                            <option value="{{ $gestion->idgestion }}" {{ $filtroGestion == $gestion->idgestion ? 'selected' : '' }}>
                                {{ $gestion->detalleges }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Nivel Educativo</label>
                    <select name="nivel" class="w-full border rounded px-3 py-2">
                        <option value="todos" {{ $filtroNivel == 'todos' ? 'selected' : '' }}>Todos</option>
                        @foreach($niveles as $nivel)
                            <option value="{{ $nivel->descripcion }}" {{ $filtroNivel == $nivel->descripcion ? 'selected' : '' }}>
                                {{ $nivel->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Estado</label>
                    <select name="estado" class="w-full border rounded px-3 py-2">
                        <option value="todos" {{ $filtroEstado == 'todos' ? 'selected' : '' }}>Todos</option>
                        <option value="1" {{ $filtroEstado == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ $filtroEstado == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Filtrar
                </button>
            </form>
        </div>

        <!-- Acordeón por Nivel Educativo -->
        @php
            $niveles = ['Inicial', 'Primaria', 'Secundaria'];
            $colores = [
                'Inicial' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'text' => 'text-purple-700', 'badge' => 'bg-purple-100'],
                'Primaria' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-700', 'badge' => 'bg-blue-100'],
                'Secundaria' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-700', 'badge' => 'bg-green-100']
            ];
        @endphp

        <div class="space-y-4">
            @foreach($niveles as $nivel)
                @php
                    $detallesNivel = collect($detalles)->filter(function($d) use ($nivel) {
                        return stripos($d->descripcion, $nivel) !== false;
                    });
                @endphp
                
                <div class="bg-white rounded-lg shadow-md border-l-4 {{ $colores[$nivel]['border'] }} overflow-hidden">
                    <!-- Header del Acordeón -->
                    <button type="button" 
                            onclick="toggleAccordion('{{ $nivel }}')"
                            class="w-full px-6 py-4 flex items-center justify-between {{ $colores[$nivel]['bg'] }} hover:shadow-lg transition-all duration-200">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full {{ $colores[$nivel]['badge'] }} flex items-center justify-center">
                                <span class="text-lg font-bold {{ $colores[$nivel]['text'] }}">
                                    @if($nivel == 'Inicial') I
                                    @elseif($nivel == 'Primaria') P
                                    @else S
                                    @endif
                                </span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold {{ $colores[$nivel]['text'] }}">Nivel {{ $nivel }}</h3>
                                <p class="text-sm text-gray-600">{{ $detallesNivel->count() }} configuración(es) de pago</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="{{ $colores[$nivel]['badge'] }} {{ $colores[$nivel]['text'] }} px-4 py-2 rounded-lg text-sm font-semibold">
                                {{ $detallesNivel->count() }}
                            </span>
                            <svg id="icon-{{ $nivel }}" class="w-6 h-6 {{ $colores[$nivel]['text'] }} transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- Contenido del Acordeón -->
                    <div id="content-{{ $nivel }}" class="hidden border-t-2 {{ $colores[$nivel]['border'] }}">
                        @if($detallesNivel->count() > 0)
                            <div class="overflow-x-auto bg-white">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Gestión</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Monto Base</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Descuento</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Monto Final</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Cuotas</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Pagos</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($detallesNivel as $detalle)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $detalle->iddetallemensualidad }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ $detalle->gestion_nombre }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                Bs. {{ number_format($detalle->monto, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($detalle->nodescuento == '1')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        -{{ $detalle->descuento }}%
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Sin descuento</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                                Bs. {{ number_format($detalle->montototal, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $detalle->cantidadmesualidades }} cuotas
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $detalle->total_mensualidades }} pagos
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                                @if($detalle->estado == '1')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        ● Activo
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                        ○ Inactivo
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                                <a href="{{ route('admin.detallemensualidad.edit', $detalle->iddetallemensualidad) }}" 
                                                   class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                                    Editar
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="px-6 py-8 text-center text-gray-500">
                                No hay detalles de mensualidad para {{ $nivel }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            @if(collect($detalles)->isEmpty())
                <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                    No hay detalles de mensualidad registrados
                </div>
            @endif
        </div>

        <script>
            function toggleAccordion(nivel) {
                const content = document.getElementById('content-' + nivel);
                const icon = document.getElementById('icon-' + nivel);
                
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                } else {
                    content.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                }
            }

            // Abrir el primer acordeón por defecto
            document.addEventListener('DOMContentLoaded', function() {
                toggleAccordion('Inicial');
            });
        </script>
    </div>
</x-admin-layout>
