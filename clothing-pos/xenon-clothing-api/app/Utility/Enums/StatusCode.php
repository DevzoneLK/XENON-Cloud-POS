<?php

namespace App\Utility\Enums;

enum StatusCode: int
{
    // Success Codes
    case SUCCESS = 200;
    case CREATED = 201;
    case ACCEPTED = 202;

    // Client Error Codes
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;

    // Server Error Codes
    case INTERNAL_SERVER_ERROR = 500;
    case NOT_IMPLEMENTED = 501;

    // Utility method to get the name from the value
    public static function getNameByValue(int $value): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case->name;
            }
        }

        return null; // Return null if value is not found
    }

    // Utility method to get the value from the name (case name to value)
    public static function getValueByName(string $name): ?int
    {
        $case = self::from($name); // This automatically gets the Enum case from the name
        return $case?->value;
    }
}
