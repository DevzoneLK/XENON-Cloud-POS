@echo off
REM Get the current script's directory (project root)
set PROJECT_ROOT=%~dp0

REM Navigate to the project directory
cd /d "%PROJECT_ROOT%"

REM Show progress for resetting migrations
echo ============================================
echo [1/6] Resetting migrations and seeding database...
php artisan migrate:fresh --seed
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to reset migrations. Exiting.
    exit /b 1
)
echo [SUCCESS] Migrations reset and seeded.
echo ============================================

REM Show progress for clearing configuration cache
echo [2/6] Clearing configuration cache...
php artisan config:clear
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to clear configuration cache. Exiting.
    exit /b 1
)
echo [SUCCESS] Configuration cache cleared.

REM Show progress for clearing route cache
echo [3/6] Clearing route cache...
php artisan route:clear
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to clear route cache. Exiting.
    exit /b 1
)
echo [SUCCESS] Route cache cleared.

REM Show progress for clearing view cache
echo [4/6] Clearing view cache...
php artisan view:clear
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to clear view cache. Exiting.
    exit /b 1
)
echo [SUCCESS] View cache cleared.

REM Show progress for clearing application cache
echo [5/6] Clearing application cache...
php artisan cache:clear
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to clear application cache. Exiting.
    exit /b 1
)
echo [SUCCESS] Application cache cleared.

REM Show progress for regenerating autoload files
echo [6/6] Regenerating Composer autoload files...
composer dump-autoload
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to regenerate autoload files. Exiting.
    exit /b 1
)
echo [SUCCESS] Composer autoload files regenerated.
echo ============================================

REM Start the Laravel development server
echo Starting Laravel development server...
php artisan serve
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to start Laravel development server. Exiting.
    exit /b 1
)
echo [SUCCESS] Laravel development server started. Open http://127.0.0.1:8000 in your browser.
echo ============================================
pause
