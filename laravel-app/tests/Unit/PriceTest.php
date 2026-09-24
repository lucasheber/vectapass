<?php

declare(strict_types=1);

use App\Domain\ValueObjects\Price;

describe('Price', function (): void {
    it('should create a price', function (): void {
        $price = new Price(100);

        expect($price)->toBeInstanceOf(Price::class);
        expect($price->amountInCents())->toBeInt();
        expect($price->currency())->toBeString()->toBe('BRL');
    });

    it('should not create a price with a negative amount', function (): void {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessageIsOrContains('The price amount cannot be negative.');
        new Price(-100);
    });

    it('should not create a price with a currency empty', function (): void {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessageIsOrContains('The currency must be a ISO 4217 three letter code.');
        new Price(100, '');
    });

    it('should not create a price with a currency invalid', function (): void {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessageIsOrContains('The currency must be a ISO 4217 three letter code.');
        new Price(100, 'USDZ');
    });
});
