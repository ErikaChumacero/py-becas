@echo off
echo ========================================
echo LIMPIANDO CACHE DE LARAVEL
echo ========================================
echo.

cd /d "%~dp0"

echo [1/4] Limpiando cache de vistas...
php artisan view:clear

echo [2/4] Limpiando cache de configuracion...
php artisan config:clear

echo [3/4] Limpiando cache de rutas...
php artisan route:clear

echo [4/4] Limpiando cache general...
php artisan cache:clear

echo.
echo ========================================
echo CACHE LIMPIADA EXITOSAMENTE
echo ========================================
echo.
echo Ahora recarga la pagina en el navegador (Ctrl + F5)
echo.
pause
