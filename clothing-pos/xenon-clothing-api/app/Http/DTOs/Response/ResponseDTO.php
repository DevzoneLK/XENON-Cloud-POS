<?php

namespace App\Http\DTOs\Response;

use App\Platform\Enums\StatusCode;
use App\Platform\Utility\Debug;

class ResponseDTO
{
    private bool $success;
    private string $message;
    private array $data;
    private array $additionalParams;
    private StatusCode $statusCode;
    private string $timestamp;

    public function __construct(StatusCode $statusCode = null, string $message, array $data = [], array $additionalParams = [])
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
        $this->additionalParams = app()->environment('development', 'test') ? ($additionalParams ?? []) : [];
        $this->timestamp = now();
        $this->setSuccessFlag($statusCode);
        $this->data['environment'] = app()->environment();
    }

    public function toArray(): array
    {
        // Base response structure
        $response = [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'timestamp' => $this->timestamp,
        ];

        // Include debug information in development or test environments
        if (app()->environment('development', 'test')) {
            $debugUtility = new Debug();
            $response['debug-enabled'] = config('app.debug');
            if (config('app.debug')) {
                $response['configurations'] = $debugUtility->getDebugDatabaseConfig();
            }
        }

        // Merge additional parameters, allowing override or new keys
        return array_merge($response, $this->additionalParams);
    }

    public function toJson()
    {
        return response()->json($this->toArray(), $this->statusCode->value);
    }

    private function setSuccessFlag(StatusCode $statusCode): void
    {
        $this->success = $this->statusCode->value === 200 || $this->statusCode->value === 201 || $this->statusCode->value === 202 ? true : false;
    }

    public function getStatusCode(): StatusCode
    {
        return $this->statusCode;
    }

    public function setStatusCode(StatusCode $statusCode): void
    {
        $this->statusCode = $statusCode;
        // Update success flag based on status code
        $this->setSuccessFlag($statusCode);
    }
}