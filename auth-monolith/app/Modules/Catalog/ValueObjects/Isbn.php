<?php

namespace App\Modules\Catalog\ValueObjects;

use InvalidArgumentException;

class Isbn
{
    private string $value;

    public function __construct(string $value)
    {
        $cleaned = str_replace('-', '', $value);
        if (!preg_match('/^\d{10}(\d{3})?$/', $cleaned)) {
            throw new InvalidArgumentException("Format ISBN tidak valid: {$value}");
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}