@echo off

:: Stop the Laravel development server (if running)
echo Stopping Laravel server...
taskkill /f /im "php.exe"

:: Clear application cache and config cache
echo Clearing application cache and config cache...
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan view:clear

:: Ensure that the .env file is loaded correctly
echo Loading new .env variables...
composer dump-autoload

:: Start the Laravel development server again
echo Starting Laravel server...
start php artisan serve
