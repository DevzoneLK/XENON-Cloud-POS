<?php
// app/Console/Commands/GenerateModule.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class GenerateModule extends Command
{
    protected $signature = 'generate:module {name}';
    protected $description = 'Generate module structure with controllers, models, migrations, seeders, etc.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the module name from the argument
        $moduleName = ucfirst($this->argument('name'));

        // Convert the module name to kebab-case (with '-module' appended at the end)
        $moduleFolderName = Str::kebab($moduleName) . '-module'; // e.g., SizeGuide -> size-guide-module

        // Define the module path using the kebab-case folder name
        $modulePath = app_path('Modules/' . $moduleFolderName);

        // Check if the module folder already exists
        if (File::exists($modulePath)) {
            $this->error("Module {$moduleName} already exists!");
            return;
        }

        try {
            // Create the module folder
            File::makeDirectory($modulePath, 0777, true);

            // Create subfolders (controller, database, enums, models, routes)
            $this->createSubfolders($modulePath);

            // Create the module files
            $this->createModuleFiles($modulePath, $moduleName);

            // Update the modules configuration
            $this->updateModulesConfig($moduleName);

            // Update composer.json for PSR-4 autoloading
            $this->updateComposerAutoload($moduleName);

            // Regenerate Composer autoload files
            exec('composer dump-autoload');

            // Success message
            $this->info("Module {$moduleName} created and autoload updated successfully.");
        } catch (\Exception $e) {
            // Rollback: If any part of the process fails, remove the created directory and update composer.json
            $this->error("Error during module creation: " . $e->getMessage());

            // Remove the partially created module folder
            File::deleteDirectory($modulePath);

            // Rollback composer.json changes if any
            // $this->rollbackComposerJson($moduleFolderName);

            // Optionally, regenerate composer autoload to revert changes in composer.json
            // exec('composer dump-autoload');

            return;
        }
    }

    /**
     * Create subfolders for the module
     *
     * @param string $modulePath
     */
    private function createSubfolders(string $modulePath)
    {
        $subfolders = [
            'Controllers',
            'Database/Migrations',
            'Database/Seeders',
            'Services',
            'Enums',
            'Models',
            'Routes',
            'DTOs',
            'Mappers',
        ];

        foreach ($subfolders as $folder) {
            $folderPath = $modulePath . '/' . $folder;
            File::makeDirectory($folderPath, 0755, true);
        }
    }

    /**
     * Create the necessary files inside the module folder
     *
     * @param string $modulePath
     * @param string $moduleName
     */
    private function createModuleFiles(string $modulePath, string $moduleName)
    {
        // Controller file
        $this->createController($modulePath, $moduleName);

        // Model file
        $this->createModel($modulePath, $moduleName);

        // Service file
        $this->createService($modulePath, $moduleName);

        // Enum file
        $this->createEnum($modulePath, $moduleName);

        // Routes file
        $this->createRoutes($modulePath, $moduleName);

        // Migration file
        $this->createMigration($modulePath, $moduleName);

        // Seeder file
        $this->createSeeder($modulePath, $moduleName);
    }

    /**
     * Create a controller file
     *
     * @param string $modulePath
     * @param string $moduleName
     */
    private function createController(string $modulePath, string $moduleName)
    {
        // $controllerPath = $modulePath . '/Controllers/' . $moduleName . 'Controller.php';
        // $controllerContent = "<?php\n\nnamespace App\\Modules\\{$moduleName}\\Controllers;\n\nuse App\\Http\\Controllers\\Controller;\n\nuse Illuminate\\Http\\Request;\n\nclass {$moduleName}Controller extends Controller\n{\n    public function index()\n    {\n        return response()->json(['message' => '{$moduleName} Module Controller']);\n    }\n}\n";

        // File::put($controllerPath, $controllerContent);
        $controllerName = "{$moduleName}Controller";

        // Use Artisan to call the controller generation script
        $result = Artisan::call('make:module-controller', [
            'module' => $moduleName,
            'name' => $moduleName
        ]);

        if ($result === 0) {
            $this->info("Controller {$controllerName} has been successfully created for module {$moduleName}.");
        } else {
            $this->error("Failed to create controller {$controllerName} for module {$moduleName}.");
        }
    }

    /**
     * Create a model file
     *
     * @param string $modulePath
     * @param string $moduleName
     */
    private function createModel(string $modulePath, string $moduleName)
    {
        // $modelPath = $modulePath . '/Models/' . $moduleName . '.php';
        // $modelContent = "<?php\n\nnamespace App\\Modules\\{$moduleName}\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Model;\n\nclass {$moduleName} extends Model\n{\n    protected \$table = '" . Str::snake($moduleName) . "';\n}\n";

        // File::put($modelPath, $modelContent);
        $modelName = $moduleName;

        // Use Artisan to call the model generation script
        $result = Artisan::call('make:module-model', [
            'module' => $moduleName,
            'name' => $modelName
        ]);

        if ($result === 0) {
            $this->info("Model {$modelName} has been successfully created for module {$moduleName}.");
        } else {
            $this->error("Failed to create model {$modelName} for module {$moduleName}.");
        }

    }

    /**
     * Create a model file
     *
     * @param string $modulePath
     * @param string $moduleName
     */
    private function createService(string $modulePath, string $moduleName)
    {
        // $modelPath = $modulePath . '/Models/' . $moduleName . '.php';
        // $modelContent = "<?php\n\nnamespace App\\Modules\\{$moduleName}\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Model;\n\nclass {$moduleName} extends Model\n{\n    protected \$table = '" . Str::snake($moduleName) . "';\n}\n";

        // File::put($modelPath, $modelContent);
        $modelName = $moduleName;

        // Use Artisan to call the model generation script
        $result = Artisan::call('make:module-service', [
            'module' => $moduleName,
            'name' => $modelName
        ]);

        if ($result === 0) {
            $this->info("Model {$modelName} has been successfully created for module {$moduleName}.");
        } else {
            $this->error("Failed to create model {$modelName} for module {$moduleName}.");
        }

    }

    /**
     * Create an enum file
     *
     * @param string $modulePath
     * @param string $moduleName
     */
    private function createEnum(string $modulePath, string $moduleName)
    {
        $enumPath = $modulePath . '/Enums/' . $moduleName . 'Enum.php';
        $enumContent = "<?php\n\nnamespace App\\Modules\\{$moduleName}\\Enums;\n\nclass {$moduleName}Enum\n{\n    const STATUS_ACTIVE = 1;\n    const STATUS_INACTIVE = 0;\n}\n";

        File::put($enumPath, $enumContent);
    }

    /**
     * Create routes file
     *
     * @param string $modulePath
     * @param string $moduleName
     */
    private function createRoutes(string $modulePath, string $moduleName)
    {
        $routesPath = $modulePath . '/Routes/api.php';
        $routesContent = "<?php\n\nuse App\\Modules\\{$moduleName}\\Controllers\\{$moduleName}Controller;\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::get('/{$moduleName}', [{$moduleName}Controller::class, 'index']);\n";

        File::put($routesPath, $routesContent);
    }

    /**
     * Create migration file in the module's folder.
     *
     * @param string $modulePath
     * @param string $moduleName
     */
    private function createMigration(string $modulePath, string $moduleName)
    {
        // // Convert the module name to snake_case for table naming (e.g., SizeGuide -> size_guide)
        // $tableName = Str::snake($moduleName);

        // // Define the path for migrations inside the module
        // $migrationPath = $modulePath . "/Database/Migrations/" . date('Y_m_d_His') . '_create_' . $tableName . "_table.php";

        // // Define the content for the migration file
        // $migrationContent = "<?php\n\nnamespace App\\Modules\\{$moduleName}\\Database\\Migrations;\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\nreturn new class extends Migration\n{\n    public function up()\n    {\n        Schema::create('{$tableName}', function (Blueprint \$table) {\n            \$table->id();\n            \$table->timestamps();\n        });\n    }\n\n    public function down()\n    {\n        Schema::dropIfExists('{$tableName}');\n    }\n};\n";

        // // Create the migration file with the defined content
        // File::put($migrationPath, $migrationContent);

        // Convert the module name to snake_case for table naming
        $tableName = Str::snake($moduleName);

        // Use Artisan to call the migration generation script
        $result = Artisan::call('make:module-migration', [
            'module' => $moduleName,
            'name' => $tableName,
        ]);

        if ($result === 0) {
            $this->info("Migration for table '{$tableName}' has been successfully created for module {$moduleName}.");
        } else {
            $this->error("Failed to create migration for table '{$tableName}' in module {$moduleName}.");
        }

    }

    /**
     * Create seeder file
     *
     * @param string $modulePath
     * @param string $moduleName
     */
    private function createSeeder(string $modulePath, string $moduleName)
    {
        // Convert the module name to PascalCase (e.g., UserManagement)
        $seederClassName = Str::studly($moduleName) . 'DatabaseSeeder';

        // Define the file path for the seeder
        $seederPath = $modulePath . '/Database/Seeders/' . $seederClassName . '.php';

        // Create the content of the seeder file
        $seederContent = "<?php\n\nnamespace App\\Modules\\{$moduleName}\\Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\n\nclass {$seederClassName} extends Seeder\n{\n    public function run()\n    {\n        // Seed data for {$moduleName}\n    }\n}\n";

        // Create the file with the generated content
        File::put($seederPath, $seederContent);
    }

    /**
     * Updates the config/modules.php file with the new module name.
     *
     * @param string $moduleName
     */
    protected function updateModulesConfig(string $moduleName)
    {
        $configFilePath = config_path('modules.php');

        // Check if the config file exists
        if (!File::exists($configFilePath)) {
            $this->error('Config file modules.php not found.');
            return;
        }

        // Read the existing modules from the config file
        $modules = include $configFilePath;

        // Check if the module already exists in the config
        if (in_array($moduleName, $modules)) {
            $this->error("Module '{$moduleName}' already exists in the configuration.");
            return;
        }

        // Add the new module to the list
        $modules[] = $moduleName;

        // Convert the array into a human-readable PHP code format
        $updatedConfigContent = "<?php\n\nreturn [\n";
        foreach ($modules as $module) {
            $updatedConfigContent .= "    '{$module}',\n";
        }
        $updatedConfigContent .= "];\n";

        // Write the updated content back to the config file
        File::put($configFilePath, $updatedConfigContent);
    }

    /**
     * Add the new module namespace to the autoload section of composer.json.
     *
     * @param string $moduleName
     */
    protected function updateComposerAutoload(string $moduleName)
    {
        // Path to the composer.json file
        $composerFilePath = base_path('composer.json');

        // Check if composer.json exists
        if (!File::exists($composerFilePath)) {
            $this->error('composer.json file not found.');
            return;
        }

        // Get the current content of composer.json
        $composerContent = json_decode(File::get($composerFilePath), true);

        // Add the new module to the PSR-4 autoload section
        $moduleNamespace = 'App\\Modules\\' . $moduleName . '\\'; // Ensure trailing backslash
        $modulePath = 'app/Modules/' . Str::kebab($moduleName) . '-module/';

        if (!isset($composerContent['autoload']['psr-4'][$moduleNamespace])) {
            $composerContent['autoload']['psr-4'][$moduleNamespace] = $modulePath;

            // Save the updated composer.json file
            File::put($composerFilePath, json_encode($composerContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->info("composer.json updated with new module autoload namespace.");
        } else {
            $this->info("PSR-4 autoload for {$moduleNamespace} already exists.");
        }
    }
}
