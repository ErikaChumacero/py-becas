@echo off
echo ========================================
echo LIMPIANDO CACHE - ESPERA...
echo ========================================
echo.

cd /d "%~dp0"

php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan cache:clear

echo.
echo ========================================
echo CACHE LIMPIADA
echo ========================================
echo.
echo AHORA RECARGA LA PAGINA CON CTRL + F5
echo.
pause
