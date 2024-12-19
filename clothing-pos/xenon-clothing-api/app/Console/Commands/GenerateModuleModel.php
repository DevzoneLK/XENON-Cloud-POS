<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModuleModel extends Command
{
    protected $signature = 'make:module-model {module} {name}';
    protected $description = 'Generate a model in a specified module';

    public function handle()
    {
        $moduleName = $this->argument('module');
        $modelName = $this->argument('name');

        // Normalize module name (e.g., ProductionModule -> production-module)
        $moduleFolderName = Str::kebab($moduleName) . '-module';

        // Load paths from config/module_paths.php
        $modulePaths = config('module_paths');

        if (!isset($modulePaths['models'])) {
            $this->error('Model path is not defined in module_paths.php.');
            return 1; // FAILURE
        }

        $modelPath = str_replace('{module_name}', $moduleFolderName, $modulePaths['models']);

        if (!File::exists($modelPath)) {
            File::makeDirectory($modelPath, 0755, true);
        }

        $modelFilePath = $modelPath . '/' . $modelName . '.php';

        if (File::exists($modelFilePath)) {
            $this->error("Model {$modelName} already exists in module {$$moduleName}.");
            return 1; // FAILURE
        }

        $namespace = "App\\Modules\\" . Str::studly($moduleName) . "\\Models";

        $modelTemplate = <<<PHP
<?php

namespace $namespace;

use Illuminate\Database\Eloquent\Model;

class $modelName extends Model
{
    protected \$table = '{$this->generateTableName($modelName)}';
    protected \$fillable = [
        // Add your fillable attributes here
    ];
}
PHP;

        File::put($modelFilePath, $modelTemplate);

        $this->info("Model {$modelName} has been created in module {$moduleName}.");
        return 0; // SUCCESS
    }

    /**
     * Generate table name from model name.
     * Converts 'SizeGuide' to 'size_guides'.
     *
     * @param string \$modelName
     * @return string
     */
    private function generateTableName(string $modelName): string
    {
        return Str::snake(Str::pluralStudly($modelName));
    }
}
