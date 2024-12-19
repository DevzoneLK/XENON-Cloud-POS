<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeleteModule extends Command
{
    // Define the command's signature and description
    protected $signature = 'delete:module {name}';
    protected $description = 'Delete a module with its files and folders.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $moduleName = $this->argument('name');

        // Convert the module name to kebab-case and append '-module' at the end
        $moduleFolderName = Str::kebab($moduleName) . '-module'; // e.g., SizeGuide -> size-guide-module

        // Define the module path using the updated folder name
        $modulePath = app_path('Modules/' . $moduleFolderName);

        // Check if the module folder exists
        if (!File::exists($modulePath)) {
            $this->error("Module directory does not exist: $modulePath");
            return;
        }

        // Confirm with the user before deleting
        if (!$this->confirm("Are you sure you want to delete the module: $moduleName? This action cannot be undone.")) {
            $this->info('Module deletion canceled.');
            return;
        }

        // Delete the module folder and all its contents
        $this->info("Deleting module: $moduleName...");
        File::deleteDirectory($modulePath);

        // Update the modules configuration to remove the module name
        $this->removeModuleFromConfig($moduleName);

        // Update composer.json to remove the PSR-4 autoload entry for the module
        $this->removeModuleFromComposerJson($moduleName);

        // Optionally, regenerate Composer autoload
        exec('composer dump-autoload');

        $this->info("Module deleted: $moduleName");
    }

    /**
     * Updates the config/modules.php file to remove the given module name.
     *
     * @param string $moduleName
     */
    protected function removeModuleFromConfig(string $moduleName)
    {
        $configFilePath = config_path('modules.php');

        // Check if the config file exists
        if (!File::exists($configFilePath)) {
            $this->error('Config file modules.php not found.');
            return;
        }

        // Read the existing modules from the config file
        $modules = include $configFilePath;

        // Check if the module exists in the config
        if (!in_array($moduleName, $modules)) {
            $this->error("Module '{$moduleName}' does not exist in the configuration.");
            return;
        }

        // Remove the module from the list
        $modules = array_filter($modules, fn($module) => $module !== $moduleName);

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
     * Removes the PSR-4 autoload entry for the module from composer.json.
     *
     * @param string $moduleFolderName
     */
    protected function removeModuleFromComposerJson($moduleName)
    {
        $composerJsonPath = base_path(path: 'composer.json');

        // Check if the composer.json file exists
        if (!File::exists($composerJsonPath)) {
            $this->error('composer.json file not found.');
            return;
        }

        // Read the composer.json file content
        $composerJson = json_decode(File::get($composerJsonPath), true);

        // Check if the PSR-4 autoload section exists
        if (isset($composerJson['autoload']['psr-4'])) {
            // Build the namespace for the module (convert kebab-case to PascalCase)
            $namespace = 'App\\Modules\\' . $moduleName . '\\'; // Ensure PascalCase

            // Check if the namespace exists in the PSR-4 autoload section
            if (isset($composerJson['autoload']['psr-4'][$namespace])) {
                // Remove the PSR-4 autoload entry for the module
                unset($composerJson['autoload']['psr-4'][$namespace]);
                $this->info("Removed PSR-4 autoload entry for module {$namespace} from composer.json.");
            } else {
                $this->info("PSR-4 autoload entry for {$namespace} not found in composer.json.");
            }

            // Save the updated composer.json content
            $updatedJson = json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            // Ensure the changes are written back to the file
            if (File::put($composerJsonPath, $updatedJson)) {
                $this->info("composer.json updated successfully.");
            } else {
                $this->error("Failed to update composer.json.");
            }
        } else {
            $this->info('PSR-4 autoload section not found in composer.json.');
        }
    }

}
