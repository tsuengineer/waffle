<?php

namespace App\Utils;

class ResponseUtil
{
    private bool $success;
    private array $errors;

    public function __construct(bool $success, array $errors = [])
    {
        $this->success = $success;
        $this->errors = $errors;
    }

    public static function createSuccess(): self
    {
        return new self(true);
    }

    public static function updateSuccess(): self
    {
        return new self(true);
    }

    public static function deleteSuccess(): self
    {
        return new self(true);
    }

    public static function createWithErrors(array $errors): self
    {
        return new self(false, $errors);
    }

    public static function updateWithErrors(array $errors): self
    {
        return new self(false, $errors);
    }

    public static function deleteWithErrors(array $errors): self
    {
        return new self(false, $errors);
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
