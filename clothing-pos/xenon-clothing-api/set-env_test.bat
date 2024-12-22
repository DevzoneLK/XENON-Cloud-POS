@echo off
echo Copying .env.test to .env
copy /y ".env-test" ".env"
echo .env file created for test environment.