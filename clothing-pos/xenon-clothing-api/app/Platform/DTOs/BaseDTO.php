<?php

namespace App\Platform\DTOs;

abstract class BaseDTO
{

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function toJson()
    {
        return response()->json($this->toArray());
    }
}