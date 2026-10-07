<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use DomainException;

final class Identifier
{
    private const UUID_PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-8][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

    private function __construct(private string $value)
    {
        $this->validate();
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validate(): void
    {
        if (empty($this->value)) {
            throw new DomainException('The identifier cannot be empty.');
        }

        if (preg_match(self::UUID_PATTERN, $this->value) !== 1) {
            throw new DomainException('The identifier must be a valid UUID.');
        }
    }
}
