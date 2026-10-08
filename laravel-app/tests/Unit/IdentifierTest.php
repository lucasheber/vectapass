<?php

declare(strict_types=1);

use App\Domain\ValueObjects\Identifier;

describe('Identifier', function (): void {
    it('should create a valid identifier', function (): void {
        $identifier = Identifier::create('123e4567-e89b-12d3-a456-426614174000');
        expect($identifier->value())->toBe($identifier->value());
    });

    it('should throw an exception if the identifier is not a valid UUID', function (): void {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessageIsOrContains('The identifier must be a valid UUID.');
        Identifier::create('invalid-uuid');
    });

    it('should throw an exception if the identifier is empty', function (): void {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessageIsOrContains('The identifier cannot be empty.');
        Identifier::create('');
    });
});
