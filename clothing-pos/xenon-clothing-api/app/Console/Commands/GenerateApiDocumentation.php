<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class GenerateApiDocumentation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:api-docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate HTML file with documentation for all APIs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all routes from the API
        $routes = Route::getRoutes();

        // Start the HTML content
        $html = '<html><head><title>API Documentation</title></head><body>';
        $html .= '<h1>API Documentation</h1>';

        // Group routes by API (module) name
        $groupedRoutes = $this->groupRoutesByApi($routes);

        // Loop through each API and create a subheading and table
        foreach ($groupedRoutes as $apiName => $apiRoutes) {
            $html .= "<h2>{$apiName} API</h2>";
            $html .= '<table border="1" cellpadding="5" cellspacing="0">';
            $html .= '<thead><tr><th>Method</th><th>Route</th><th>Parameters</th></tr></thead>';
            $html .= '<tbody>';

            // Add each route for this specific API
            foreach ($apiRoutes as $route) {
                $method = strtoupper($route['method']);  // HTTP method (GET, POST, etc.)
                $uri = $route['uri'];  // URI of the route
                $parameters = $route['parameters'];  // Route parameters

                // Add the route information to the table
                $html .= "<tr><td>{$method}</td><td>{$uri}</td><td>{$parameters}</td></tr>";
            }

            $html .= '</tbody></table>';
        }

        $html .= '</body></html>';

        // Define the output file path
        $outputPath = public_path('api-documentation.html');

        // Save the HTML content to the file
        file_put_contents($outputPath, $html);

        $this->info('API documentation generated successfully! Check the file at ' . $outputPath);
    }

    /**
     * Group the routes by API (module) name.
     *
     * @param  \Illuminate\Routing\RouteCollection  $routes
     * @return array
     */
    private function groupRoutesByApi(\Illuminate\Routing\RouteCollectionInterface $routes)
    {
        $groupedRoutes = [];

        foreach ($routes as $route) {
            // Check if it's an API route (based on 'api/' prefix)
            if (Str::startsWith($route->uri, 'api/')) {
                // Extract the API name from the route (e.g., api/product/create -> Product)
                $segments = explode('/', $route->uri);
                $apiName = ucfirst($segments[1] ?? 'General'); // Get the second part of the URI as the API name

                // Store route info
                $routeInfo = [
                    'method' => $route->methods[0], // HTTP method (GET, POST, etc.)
                    'uri' => $route->uri,
                    'parameters' => $this->getRouteParameters($route),
                ];

                // Group routes under the API name
                $groupedRoutes[$apiName][] = $routeInfo;
            }
        }

        return $groupedRoutes;
    }

    /**
     * Get the expected parameters for a given route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return string
     */
    private function getRouteParameters($route)
    {
        $parameters = [];

        // Only retrieve parameters if the route has any
        if ($route->parameterNames()) {
            foreach ($route->parameterNames() as $parameter) {
                $parameters[] = $parameter; // Add parameter name (key)
            }
        }

        // Return the parameters as a comma-separated string or 'None' if no parameters
        return implode(', ', $parameters) ?: 'None';
    }
}
