<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Utility\Helpers\ModulePathHelper;
use Illuminate\Support\Str;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $modules = config('modules');

        if (!is_array($modules) || empty($modules)) {
            return; // No modules defined
        }

        foreach ($modules as $module) {
            try {
                $moduleName = ucfirst($module);
                $moduleFolderName = Str::kebab($moduleName) . '-module';
                // Get the migration path for each module
                $migrationPath = ModulePathHelper::getModulePath($moduleFolderName, 'migrations');

                // Load the migration path if it exists
                if (is_dir($migrationPath)) {
                    $this->loadMigrationsFrom($migrationPath);
                } else {
                    logger()->error("{$module} module Migration path not found:{$migrationPath} ");
                }
            } catch (\Exception $e) {
                // Handle exceptions (e.g., invalid path or configuration issues)
                logger()->error("Error loading migrations for module {$module}: " . $e->getMessage());
            }
        }
    }
}
