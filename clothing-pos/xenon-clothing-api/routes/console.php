<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\GenerateModule;
use App\Console\Commands\DeleteModule;
use App\Console\Commands\CreateModuleMigration;
use App\Console\Commands\GenerateModuleController;
use App\Console\Commands\GenerateModuleModel;
use App\Console\Commands\GenerateModuleService;
use App\Console\Commands\GenerateEntityFiles;
use App\Console\Commands\GenerateModuleDTO;
use App\Console\Commands\GenerateApiDocumentation;

Artisan::command('inspires', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('generate:module {name}', function ($name) {
    $this->call(GenerateModule::class, ['name' => $name]);
})->describe('Generate a new module');

Artisan::command('delete:module {name}', function ($name) {
    $this->call(DeleteModule::class, ['name' => $name]);
})->describe('Delete a module and its contents');

Artisan::command('make:module-migration {module} {name}', function ($module, $name) {
    $this->call(CreateModuleMigration::class, ['module' => $module, 'name' => $name]);
})->describe('Generate a module migration');

Artisan::command('make:module-controller {module} {name}', function ($module, $name) {
    $this->call(GenerateModuleController::class, ['module' => $module, 'name' => $name]);
})->describe('Generate a module controller');

Artisan::command('make:module-model {module} {name}', function ($module, $name) {
    $this->call(GenerateModuleModel::class, ['module' => $module, 'name' => $name]);
})->describe('Generate a module model');

Artisan::command('make:module-service {module} {name}', function ($module, $name) {
    $this->call(GenerateModuleService::class, ['module' => $module, 'name' => $name]);
})->describe('Generate a module Service');

Artisan::command('generate:entity {module} {name}', function ($module, $name) {
    $this->call(GenerateEntityFiles::class, ['module' => $module, 'name' => $name]);
})->describe('Generate controller, model, service, DTO and migration files for a specific entity in a given module');

Artisan::command('make:module-dto {module} {name}', function ($module, $name) {
    $this->call(GenerateModuleDTO::class, ['module' => $module, 'name' => $name]);
})->describe('Generate Module DTO, in a given module');

Artisan::command('generate:api-docs', function () {
    $this->call(GenerateApiDocumentation::class, []);
})->describe('Generate HTML file with documentation for all APIs');