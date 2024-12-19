@echo off
REM Get the current script's directory (project root)
set PROJECT_ROOT=%~dp0

REM Navigate to the project directory
cd /d "%PROJECT_ROOT%"

REM Display header
echo ============================================
echo Starting update process...
echo ============================================

REM [1/6] Running missing migrations
echo [1/6] Running missing migrations...
php artisan migrate
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to run migrations. Exiting.
    exit /b 1
)
echo [SUCCESS] Missing migrations executed.

REM [2/6] Running seeders for missing data
echo [2/6] Running seeders for missing data...
php artisan db:seed --force
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to run seeders. Exiting.
    exit /b 1
)
echo [SUCCESS] Seeders executed.

REM [3/6] Clearing configuration cache
echo [3/6] Clearing configuration cache...
php artisan config:clear
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to clear configuration cache. Exiting.
    exit /b 1
)
echo [SUCCESS] Configuration cache cleared.

REM [4/6] Clearing route cache
echo [4/6] Clearing route cache...
php artisan route:clear
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to clear route cache. Exiting.
    exit /b 1
)
echo [SUCCESS] Route cache cleared.

REM [5/6] Clearing view cache
echo [5/6] Clearing view cache...
php artisan view:clear
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to clear view cache. Exiting.
    exit /b 1
)
echo [SUCCESS] View cache cleared.

REM [6/6] Regenerating Composer autoload files
echo [6/6] Regenerating Composer autoload files...
composer dump-autoload
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to regenerate autoload files. Exiting.
    exit /b 1
)
echo [SUCCESS] Composer autoload files regenerated.
echo ============================================

REM End of process
echo Update process completed successfully.
pause
