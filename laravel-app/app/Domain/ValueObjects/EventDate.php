<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use DateTimeImmutable;
use DomainException;

final readonly class EventDate
{
    public function __construct(
        private DateTimeImmutable $value,
    ) {
        if ($this->value < new DateTimeImmutable('now')) {
            throw new DomainException('The event date cannot be in the past.');
        }
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value == $other->value;
    }
}
