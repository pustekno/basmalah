@echo off
echo ========================================
echo   RBAC System - Quick Commands
echo ========================================
echo.
echo 1. Run Seeder
echo 2. Test RBAC System
echo 3. Clear Cache
echo 4. Start Server
echo 5. Exit
echo.
set /p choice="Enter your choice (1-5): "

if "%choice%"=="1" (
    echo.
    echo Running RolePermissionSeeder...
    php artisan db:seed --class=RolePermissionSeeder
    pause
    goto menu
)

if "%choice%"=="2" (
    echo.
    echo Testing RBAC System...
    php artisan rbac:test
    pause
    goto menu
)

if "%choice%"=="3" (
    echo.
    echo Clearing cache...
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
    php artisan permission:cache-reset
    echo Cache cleared!
    pause
    goto menu
)

if "%choice%"=="4" (
    echo.
    echo Starting Laravel server...
    echo Open browser: http://localhost:8000
    php artisan serve
    pause
    goto menu
)

if "%choice%"=="5" (
    exit
)

:menu
cls
goto :eof
