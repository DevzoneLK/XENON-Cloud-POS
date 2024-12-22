@echo off
echo Copying .env.development to .env
copy /y ".env-development" ".env"
echo .env file created for development environment.
