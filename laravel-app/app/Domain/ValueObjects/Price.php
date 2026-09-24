<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use DomainException;

final readonly class Price
{
    private int $amountInCents;

    private string $currency;

    public function __construct(int $amountInCents, string $currency = 'BRL')
    {
        if ($amountInCents < 0) {
            throw new DomainException('The price amount cannot be negative.');
        }

        $currency = strtoupper(trim($currency));

        if (preg_match('/^[A-Z]{3}$/', $currency) !== 1) {
            throw new DomainException('The currency must be a ISO 4217 three letter code.');
        }

        $this->amountInCents = $amountInCents;
        $this->currency = $currency;
    }

    public function amountInCents(): int
    {
        return $this->amountInCents;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function equals(self $other): bool
    {
        return $this->amountInCents === $other->amountInCents
            && $this->currency === $other->currency;
    }
}
