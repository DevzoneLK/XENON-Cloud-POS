<?php

namespace App\Platform\Utility;
class Debug
{
    public function getDebugDatabaseConfig()
    {
        // Fetch database connection configuration
        $databaseConfig = config('database.connections.mysql');

        // Return as a JSON response
        return response()->json([
            'database_config' => $databaseConfig,
        ]);
    }
}