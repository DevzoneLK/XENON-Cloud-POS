
# Laravel Project Commands Cheat Sheet

This document serves as a quick reference for PHP commands when developing with Laravel for creating and managing APIs.

## Setup and Installation

1. **Create a new Laravel project**  
   ```bash
   composer create-project --prefer-dist laravel/laravel project_name
   ```
   
2. **Install project dependencies**  
   ```bash
   composer install
   npm install && npm run dev # If using frontend scaffolding
   ```
   
3. **Set up environment file**  
   Copy the `.env.example` file to `.env` and update the settings accordingly:  
   ```bash
   cp .env.example .env
   ```
   Generate an application key:  
   ```bash
   php artisan key:generate
   ```
   
4. **Run database migrations**  
   ```bash
   php artisan migrate
   ```
   
5. **Seed the database (optional)**  
   ```bash
   php artisan db:seed
   ```
   
## Development Commands

1. **Serve the application locally**  
   ```bash
   php artisan serve
   ```
   
2. **Create a new controller**  
   ```bash
   php artisan make:controller ControllerName
   ```
   
3. **Create a new model**  
   ```bash
   php artisan make:model ModelName
   ```
   
4. **Create a new migration**  
   ```bash
   php artisan make:migration create_table_name_table
   ```
   
5. **Run migrations with seeds**  
   ```bash
   php artisan migrate --seed
   ```
   
6. **Rollback the last migration**  
   ```bash
   php artisan migrate:rollback
   ```
   
7. **Rollback all migrations and re-run migrations**  
   ```bash
   php artisan migrate:fresh --seed
   ```
   
8. **Create a new middleware**  
   ```bash
   php artisan make:middleware MiddlewareName
   ```
   
9. **Create a new API resource controller**  
   ```bash
   php artisan make:controller ControllerName --api
   ```
   
10. **Create a new request validation class**  
    ```bash
    php artisan make:request RequestName
    ```
   
11. **Clear application cache**  
    ```bash
    php artisan cache:clear
    ```
   
12. **Clear route cache**  
    ```bash
    php artisan route:clear
    ```
   
13. **Clear configuration cache**  
    ```bash
    php artisan config:clear
    ```
   
14. **Clear compiled view cache**  
    ```bash
    php artisan view:clear
    ```
   
15. **Rebuild all caches**  
    ```bash
    php artisan optimize
    ```
   
## Authentication Commands (If using Laravel Breeze, Sanctum, or Passport)

1. **Install Laravel Breeze (optional)**  
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install
   npm install && npm run dev
   php artisan migrate
   ```
   
2. **Install Laravel Sanctum (for token-based authentication)**  
   ```bash
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```
   
3. **Install Laravel Passport (for OAuth2)**  
   ```bash
   composer require laravel/passport
   php artisan migrate
   php artisan passport:install
   ```
