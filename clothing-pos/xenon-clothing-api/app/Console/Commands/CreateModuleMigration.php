<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CreateModuleMigration extends Command
{
    // Command signature
    protected $signature = 'make:module-migration {module} {name}';
    protected $description = 'Create a new migration for a specific module';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the module and migration name from the arguments
        $module = $this->argument('module');
        $migrationName = $this->argument('name');

        // Fetch module paths from the config file
        $modulePaths = config('module_paths');

        // Get the migration path for the specified module
        $migrationPath = str_replace(
            '{module_name}',
            Str::kebab($module) . '-module',
            $modulePaths['migrations']
        );

        // Check if the migration directory exists, if not, create it
        if (!File::exists($migrationPath)) {
            File::makeDirectory($migrationPath, 0755, true);
        }

        // Format the table name in snake_case (e.g., sizeGuide => size_guide)
        $tableName = Str::snake($migrationName);

        // Generate the timestamp for the migration file
        $timestamp = now()->format('Y_m_d_His'); // Example: 2024_11_30_123456

        // Create the migration filename with timestamp
        $migrationFileName = $timestamp . '_create_' . $tableName . '_table.php';
        $migrationFilePath = $migrationPath . '/' . $migrationFileName;

        // Create the migration file content with an anonymous class
        $migrationStub = $this->getMigrationStub($tableName);

        // Write the migration file
        File::put($migrationFilePath, $migrationStub);

        // Output success message
        $this->info("Migration created for module {$module}: {$migrationFileName}");
    }

    /**
     * Get the content of the migration file with an anonymous class
     *
     * @param string $tableName
     * @return string
     */
    private function getMigrationStub($tableName)
    {
        return <<<EOT
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('{$tableName}', function (Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('{$tableName}');
    }
};
EOT;
    }
}
