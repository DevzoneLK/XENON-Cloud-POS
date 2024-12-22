<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\DTOs\Response\ResponseDTO;
use App\Platform\Enums\StatusCode;
use Exception;
use App\Platform\Exception\ResponseErrorHandler;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handle successful responses.
     */
    protected function handleSuccessResponse($data, $message = 'Success', $statusCode = StatusCode::SUCCESS)
    {
        $response = new ResponseDTO(
            $statusCode,
            $message,
            $data,
        );

        return $response->toJson();
    }

    // Centralized exception handler
    protected function handleFailedResponse(Exception $exception, ?string $customMessage = null)
    {
        $errorHandler = new ResponseErrorHandler();
        return ($errorHandler->handle($exception, $customMessage))->toJson();
    }
}
