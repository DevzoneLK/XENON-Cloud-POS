<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class GenerateEntityFiles extends Command
{
    protected $signature = 'generate:entity {module} {name}';
    protected $description = 'Generate controller, model, service, and migration files for a specific entity in a given module';

    public function handle()
    {
        $moduleName = Str::studly($this->argument('module'));
        $entityName = Str::studly($this->argument('name'));

        // Normalize the module name to match the folder structure
        $normalizedModuleName = Str::kebab($moduleName) . '-module';

        // Check if the module directory exists
        $modulePath = base_path("app/Modules/{$normalizedModuleName}");
        if (!is_dir($modulePath)) {
            $this->error("Module '{$moduleName}' does not exist. Please create the module first.");
            return 1; // FAILURE
        }

        // Run the individual scripts for generating each file
        $this->generateController($moduleName, $entityName);
        $this->generateModel($moduleName, $entityName);
        $this->generateService($moduleName, $entityName);
        $this->generateMigration($moduleName, $entityName);
        $this->generateDTO($moduleName, $entityName);

        $this->info("All files for entity '{$entityName}' in module '{$moduleName}' have been successfully created.");
        return 0; // SUCCESS
    }

    private function generateController(string $moduleName, string $entityName)
    {
        $this->info("Generating Controller for '{$entityName}'...");
        Artisan::call('make:module-controller', [
            'module' => $moduleName,
            'name' => $entityName,
        ]);
        $this->info(trim(Artisan::output()));
    }

    private function generateModel(string $moduleName, string $entityName)
    {
        $this->info("Generating Model for '{$entityName}'...");
        Artisan::call('make:module-model', [
            'module' => $moduleName,
            'name' => $entityName,
        ]);
        $this->info(trim(Artisan::output()));
    }

    private function generateService(string $moduleName, string $entityName)
    {
        $this->info("Generating Service for '{$entityName}'...");
        Artisan::call('make:module-service', [
            'module' => $moduleName,
            'name' => $entityName,
        ]);
        $this->info(trim(Artisan::output()));
    }

    private function generateMigration(string $moduleName, string $entityName)
    {
        $this->info("Generating Migration for '{$entityName}'...");
        Artisan::call('make:module-migration', [
            'module' => $moduleName,
            'name' => $entityName,
        ]);
        $this->info(trim(Artisan::output()));
    }

    private function generateDTO(string $moduleName, string $entityName)
    {
        $this->info("Generating DTO for '{$entityName}'...");
        Artisan::call('make:module-dto', [
            'module' => $moduleName,
            'name' => $entityName,
        ]);
        $this->info(trim(Artisan::output()));
    }
}
