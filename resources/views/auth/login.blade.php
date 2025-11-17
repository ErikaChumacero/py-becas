<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Colegio Cristiana Camireña</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-500 via-green-600 to-yellow-500 flex items-center justify-center p-4">
    <!-- Patrón de fondo -->
    <div class="fixed inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="relative w-full max-w-sm">
        <!-- Card principal -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-slide-up">
            <!-- Header con gradiente -->
            <div class="bg-gradient-to-br from-green-600 to-emerald-700 p-8 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl mb-3 shadow-lg">
                        <i class="fas fa-graduation-cap text-3xl text-white"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-1">Cristiana Camireña</h1>
                    <p class="text-green-100 text-sm">Sistema de Gestión Escolar</p>
                </div>
            </div>

            <!-- Contenido del formulario -->
            <div class="p-6">
                <!-- Mensajes de error -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-3 animate-shake">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-red-800">Error al iniciar sesión</p>
                                <p class="text-xs text-red-600 mt-1">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Formulario -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    <!-- Correo electrónico -->
                    <div>
                        <label for="correo" class="block text-xs font-semibold text-gray-700 mb-1.5">Correo Electrónico</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <input 
                                id="correo" 
                                type="email" 
                                name="correo" 
                                value="{{ old('correo') }}"
                                required 
                                autofocus
                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all"
                                placeholder="correo@ejemplo.com"
                            >
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="contrasena" class="block text-xs font-semibold text-gray-700 mb-1.5">Contraseña</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-lock text-sm"></i>
                            </div>
                            <input 
                                id="contrasena" 
                                type="password" 
                                name="contrasena" 
                                required
                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all"
                                placeholder="••••••••"
                            >
                        </div>
                    </div>

                    <!-- Botón de login -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 group mt-6"
                    >
                        <span>Iniciar Sesión</span>
                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <!-- Información adicional -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <p class="text-center text-xs text-gray-500">
                        <i class="fas fa-info-circle text-green-600 mr-1"></i>
                        ¿Problemas? Contacta al administrador
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center animate-fade-in">
            <p class="text-xs text-white/90 font-medium">
                © {{ date('Y') }} Colegio Cristiana Camireña
            </p>
            <p class="text-xs text-white/70 mt-1">
                Sistema de Gestión Escolar
            </p>
        </div>
        </div>
    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }

        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animation-delay-500 {
            animation-delay: 0.5s;
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        .animate-slide-up {
            animation: slide-up 0.6s ease-out;
        }

        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</body>
</html>
