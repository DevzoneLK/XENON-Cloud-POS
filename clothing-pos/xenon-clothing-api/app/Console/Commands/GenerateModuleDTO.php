<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModuleDTO extends Command
{
    protected $signature = 'make:module-dto {module} {name}';
    protected $description = 'Generate a DTO in a specified module';

    public function handle()
    {
        $moduleName = $this->argument('module');
        $dtoName = Str::studly($this->argument('name'));

        // Normalize module name (e.g., ProductionModule -> production-module)
        $moduleFolderName = Str::kebab($moduleName) . '-module';

        // Load paths from config/module_paths.php
        $modulePaths = config('module_paths');

        if (!isset($modulePaths['dtos'])) {
            $this->error('DTO path is not defined in module_paths.php.');
            return 1; // FAILURE
        }

        $dtoPath = str_replace('{module_name}', $moduleFolderName, $modulePaths['dtos']);

        if (!File::exists($dtoPath)) {
            File::makeDirectory($dtoPath, 0755, true);
        }

        $dtoFilePath = $dtoPath . '/' . $dtoName . 'DTO.php';

        if (File::exists($dtoFilePath)) {
            $this->error("DTO {\$dtoName} already exists in module {$moduleName}.");
            return 1; // FAILURE
        }

        $namespace = "App\\Modules\\" . Str::studly($moduleName) . "\\DTOs";

        $dtoTemplate = <<<PHP
<?php

namespace $namespace;

class {$dtoName}DTO
{
    /**
     * Define your DTO properties here
     */
    public function __construct(
        // Example properties
        // public string \$exampleProperty1,
        // public int \$exampleProperty2,
    ) {}

    /**
     * Example static method to create a DTO from an array
     *
     * @param array \$data
     * @return self
     */
    public static function fromArray(array \$data): self
    {
        return new self(
            // Map properties from \$data array
            // \$data['exampleProperty1'] ?? null,
            // \$data['exampleProperty2'] ?? 0,
        );
    }

    /**
     * Example method to convert the DTO back to an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            // 'exampleProperty1' => \$this->exampleProperty1,
            // 'exampleProperty2' => \$this->exampleProperty2,
        ];
    }
}
PHP;

        File::put($dtoFilePath, $dtoTemplate);

        $this->info("DTO {$dtoName} has been created in module {$moduleName}.");
        return 0; // SUCCESS
    }
}