@echo off
echo Copying .env.production to .env
copy /y ".env.production" ".env"
echo .env file created for production environment.