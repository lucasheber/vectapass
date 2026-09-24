<?php

declare(strict_types=1);

use App\Domain\ValueObjects\EventDate;

describe('EventDate', function (): void {
    it('should create a event date', function (): void {
        $eventDate = new EventDate(new DateTimeImmutable('now +1 day'));
        expect($eventDate)->toBeInstanceOf(EventDate::class);
        expect($eventDate->value())->toBeInstanceOf(DateTimeImmutable::class);
    });

    it('should not create a event date with a date in the past', function (): void {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessageIsOrContains('The event date cannot be in the past.');
        new EventDate(new DateTimeImmutable('now -1 day'));
    });
});
