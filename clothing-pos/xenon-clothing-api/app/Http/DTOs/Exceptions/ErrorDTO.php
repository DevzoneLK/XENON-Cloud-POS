<?php

namespace App\Http\DTOs\Exceptions;

class ErrorDTO
{
    private string $message;
    private int $code;
    private string $file;
    private int $line;
    private string $trace;

    // Constructor now accepts an Exception object
    public function __construct(\Exception $exception)
    {
        $this->message = $exception->getMessage();
        $this->code = $exception->getCode();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
        $this->trace = $exception->getTraceAsString();
    }

    // Convert the error details to an array
    public function getError(): array
    {
        return [
            'message' => $this->message ,
            'code' => $this->code,
            'file' => $this->file,
            'line' => $this->line,
            'trace' => $this->trace,
        ];
    }
}
