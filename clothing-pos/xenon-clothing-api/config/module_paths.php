<?php

return [
    'base_path' => app_path('Modules/{module_name}'),
    'migrations' => app_path('Modules/{module_name}/Database/Migrations'),
    'seeders' => app_path('Modules/{module_name}/Database/Seeders'),
    'controllers' => app_path('Modules/{module_name}/Controllers'),
    'services' => app_path('Modules/{module_name}/Services'),
    'models' => app_path('Modules/{module_name}/Models'),
    'enums' => app_path('Modules/{module_name}/Enums'),
    'routes' => app_path('Modules/{module_name}/Routes'),
    'dtos' => app_path('Modules/{module_name}/DTOs'),
];
