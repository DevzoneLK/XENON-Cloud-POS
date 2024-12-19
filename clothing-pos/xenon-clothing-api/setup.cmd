@echo off
REM Get the current script's directory (project root)
set PROJECT_ROOT=%~dp0

REM Navigate to the project directory
cd /d "%PROJECT_ROOT%"

REM Show progress for installing Composer dependencies
echo ============================================
echo [1/6] Installing Composer dependencies...
composer install
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to install Composer dependencies. Exiting.
    exit /b 1
)
echo [SUCCESS] Composer dependencies installed.
echo ============================================

REM Show progress for copying the .env file
echo [2/6] Setting up the environment file...
if not exist .env (
    copy .env.example .env
    if %ERRORLEVEL% neq 0 (
        echo [ERROR] Failed to copy .env.example to .env. Exiting.
        exit /b 1
    )
    echo [SUCCESS] .env file created.
) else (
    echo [SUCCESS] .env file already exists.
)
echo ============================================

REM Show progress for generating the application key
echo [3/6] Generating application key...
php artisan key:generate
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to generate application key. Exiting.
    exit /b 1
)
echo [SUCCESS] Application key generated.
echo ============================================

REM Show progress for running migrations and seeding the database
echo [4/6] Running migrations and seeding the database...
php artisan migrate --seed
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to run migrations and seed the database. Exiting.
    exit /b 1
)
echo [SUCCESS] Migrations and database seeded.
echo ============================================

REM Show progress for clearing configuration cache
echo [5/6] Clearing configuration cache...
php artisan config:clear
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to clear configuration cache. Exiting.
    exit /b 1
)
echo [SUCCESS] Configuration cache cleared.
echo ============================================

REM Show progress for clearing route cache
echo [6/6] Clearing route cache...
php artisan route:clear
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Failed to clear route cache. Exiting.
    exit /b 1
)
echo [SUCCESS] Route cache cleared.
echo ============================================

REM Optional: Set folder permissions for Laravel storage and bootstrap/cache directories (Linux/Unix only)
echo Setting folder permissions...
if exist "storage" (
    icacls "storage" /grant "Everyone:(OI)(CI)F" /T
)
if exist "bootstrap/cache" (
    icacls "bootstrap/cache" /grant "Everyone:(OI)(CI)F" /T
)
echo Folder permissions set.

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
