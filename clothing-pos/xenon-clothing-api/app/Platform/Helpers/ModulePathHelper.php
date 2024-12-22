<?php

namespace App\Platform\Helpers;

use InvalidArgumentException;

class ModulePathHelper
{
    /**
     * Get the path for a specific module and key.
     *
     * @param string $moduleName The name of the module.
     * @param string $key The key in the module_paths configuration.
     * @return string The resolved module path.
     *
     * @throws InvalidArgumentException If the key is not found in the configuration.
     */
    public static function getModulePath(string $moduleName, string $key): string
    {
        $config = config('module_paths');

        if (!isset($config[$key])) {
            throw new InvalidArgumentException("Invalid key: {$key} in module paths configuration.");
        }

        return str_replace('/', '\\', str_replace('{module_name}', $moduleName, $config[$key]));
    }
}
