<?php

use Illuminate\Support\Facades\Route;
use App\Platform\Helpers\ModulePathHelper;
use Illuminate\Support\Str;

// Define API routes for users
Route::prefix('')->group(function () {


    $modules = config('modules');

    if (!is_array($modules) || empty($modules)) {
        return; // No modules defined
    }

    foreach ($modules as $module) {
        try {
            $moduleName = ucfirst($module);
            $moduleFolderName = Str::kebab($moduleName) . '-module';
            // Get the routes path for each module
            $migrationPath = ModulePathHelper::getModulePath($moduleFolderName, key: 'routes');
            // Load the routes path if it exists
            if (is_dir($migrationPath)) {
                require $migrationPath . '\api.php';
            }
        } catch (\Exception $e) {
            // Handle exceptions (e.g., invalid path or configuration issues)
            logger()->error("Error loading routes for module {$module}: " . $e->getMessage());
        }
    }
});