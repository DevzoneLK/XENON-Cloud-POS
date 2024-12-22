<?php

namespace App\Platform\Exception;

use Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use App\Http\DTOs\Response\ResponseDTO;
use App\Platform\Enums\StatusCode;
class ResponseErrorHandler
{
    /**
     * Handle the exception and return a structured response.
     *
     * @param  \Throwable  $exception
     * @return \App\Http\DTOs\Response\ResponseDTO
     */

    public function handle(Exception $exception, ?string $message = null)
    {
        // Handle different types of exceptions
        if ($exception instanceof ValidationException) {
            return $this->validationFailureResponse($exception, $message);
        }

        if ($exception instanceof QueryException) {
            return $this->databaseFailureResponse($exception, $message);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->modelNotFoundResponse($exception, $message);
        }

        if ($exception instanceof UnauthorizedHttpException) {
            return $this->unauthorizedResponse($exception, $message);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->methodNotAllowedResponse($exception, $message);
        }

        return $this->generalFailureResponse($exception, $message);
    }


    // Handle specific exception responses
    private function validationFailureResponse(ValidationException $exception, $message = 'Validation failed'): ResponseDTO
    {
        return new ResponseDTO(
            StatusCode::UNPROCESSABLE_ENTITY,
            $message,
            [],
            ['errors' => $exception->errors()]
        );
    }

    private function databaseFailureResponse(QueryException $exception, $message = 'Database error occurred.'): ResponseDTO
    {
        return new ResponseDTO(
            StatusCode::INTERNAL_SERVER_ERROR,
            $message,
            [],
            ['error' => $exception->getMessage()]
        );
    }

    private function modelNotFoundResponse(NotFoundHttpException $exception, $message = 'Resource not found.'): ResponseDTO
    {
        return new ResponseDTO(
            StatusCode::NOT_FOUND,
            $message,
            [],
            ['error' => $exception->getMessage()]
        );
    }

    private function unauthorizedResponse($exception, $message = 'Unauthorized access.'): ResponseDTO
    {
        return new ResponseDTO(
            StatusCode::UNAUTHORIZED,
            $message,
            [],
            ['error' => 'Authentication required. ' . $exception->getMessage()]
        );
    }

    private function methodNotAllowedResponse($exception, $message = 'Method not allowed.'): ResponseDTO
    {
        return new ResponseDTO(
            StatusCode::METHOD_NOT_ALLOWED,
            $message,
            [],
            ['error' => 'The HTTP method is not allowed for this route. ' . $exception->getMessage()]
        );
    }

    private function generalFailureResponse(Exception $exception, $message = 'An unexpected error occurred.'): ResponseDTO
    {
        return new ResponseDTO(
            StatusCode::INTERNAL_SERVER_ERROR,
            $message,
            [],
            ['error' => $exception->getMessage()]
        );
    }
}
