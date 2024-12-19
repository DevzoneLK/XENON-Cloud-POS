<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModuleService extends Command
{
    protected $signature = 'make:module-service {module} {name}';
    protected $description = 'Generate a service in a specified module';

    public function handle()
    {
        $moduleName = $this->argument('module');
        $serviceName = $this->argument('name') . 'Service';

        // Normalize module name (e.g., ProductionModule -> production-module)
        $moduleFolderName = Str::kebab($moduleName) . '-module';

        // Load paths from config/module_paths.php
        $modulePaths = config('module_paths');

        if (!isset($modulePaths['services'])) {
            $this->error('Service path is not defined in module_paths.php.');
            return 1; // FAILURE
        }

        $servicePath = str_replace('{module_name}', $moduleFolderName, $modulePaths['services']);

        if (!File::exists($servicePath)) {
            File::makeDirectory($servicePath, 0755, true);
        }

        $serviceFilePath = $servicePath . '/' . $serviceName . '.php';

        if (File::exists($serviceFilePath)) {
            $this->error("Service {$serviceName} already exists in module {$moduleName}.");
            return 1; // FAILURE
        }

        $namespace = "App\\Modules\\" . Str::studly($moduleName) . "\\Services";

        $serviceTemplate = <<<PHP
<?php

namespace $namespace;

class $serviceName
{
    public function getAll()
    {
        // Logic for retrieving all records
    }

    public function create(array \$data)
    {
        // Logic for creating a record
    }

    public function findById(int \$id)
    {
        // Logic for retrieving a record by ID
    }

    public function update(int \$id, array \$data)
    {
        // Logic for updating a record
    }

    public function delete(int \$id)
    {
        // Logic for deleting a record
    }
}
PHP;

        File::put($serviceFilePath, $serviceTemplate);

        $this->info("Service {$serviceName} has been created in module {$moduleName}.");
        return 0; // SUCCESS
    }
}
