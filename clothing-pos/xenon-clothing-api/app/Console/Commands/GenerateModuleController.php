<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModuleController extends Command
{
    protected $signature = 'make:module-controller {module} {name}';
    protected $description = 'Generate a controller in a specified module';

    public function handle()
    {
        $moduleName = $this->argument('module');
        $controllerName = $this->argument('name') . 'Controller';

        // Normalize module name (e.g., ProductionModule -> production-module)
        $moduleFolderName = Str::kebab($moduleName) . '-module';

        // Load paths from config/module_paths.php
        $modulePaths = config('module_paths');

        if (!isset($modulePaths['controllers'])) {
            $this->error('Controller path is not defined in module_paths.php.');
            return 1; // FAILURE
        }

        $controllerPath = str_replace('{module_name}', $moduleFolderName, $modulePaths['controllers']);

        if (!File::exists($controllerPath)) {
            File::makeDirectory($controllerPath, 0755, true);
        }

        $controllerFilePath = $controllerPath . '/' . $controllerName . '.php';

        if (File::exists($controllerFilePath)) {
            $this->error("Controller {$controllerName} already exists in module {$moduleName}.");
            return 1; // FAILURE
        }

        $namespace = "App\\Modules\\" . Str::studly($moduleName) . "\\Controllers";

        $controllerTemplate = <<<PHP
<?php

namespace $namespace;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class $controllerName extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request \$request)
    {
        //
    }

    public function show(\$id)
    {
        //
    }

    public function update(Request \$request, \$id)
    {
        //
    }

    public function destroy(\$id)
    {
        //
    }
}
PHP;

        File::put($controllerFilePath, $controllerTemplate);

        $this->info("Controller {$controllerName} has been created in module {$moduleName}.");
        return 0; // SUCCESS
    }
}
