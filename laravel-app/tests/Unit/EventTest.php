<?php

declare(strict_types=1);

use App\Domain\Entities\Event;
use App\Domain\ValueObjects\EventDate;
use App\Domain\ValueObjects\Price;
use Faker\Provider\Uuid;

describe('Event', function (): void {
    it('should create an event', function (): void {

        $event = Event::create(
            id: Uuid::uuid(),
            name: 'Test Event',
            date: new EventDate(new DateTimeImmutable('now +1 day')),
            price: new Price(100),
        );

        expect($event)->toBeInstanceOf(Event::class);
        expect($event->id())->toBeString();
        expect($event->name())->toBeString();
        expect($event->date())->toBeInstanceOf(EventDate::class);
        expect($event->price())->toBeInstanceOf(Price::class);
        expect($event->documentPath())->toBeNull();
    });

    it('should not create an event with a name empty', function (): void {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessageIsOrContains('The event name is required.');
        Event::create(
            id: Uuid::uuid(),
            name: '',
            date: new EventDate(new DateTimeImmutable('now +1 day')),
            price: new Price(100),
        );
    });

    it('should not create an event with a document path empty', function (): void {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessageIsOrContains('The document path cannot be empty.');
        Event::create(
            id: Uuid::uuid(),
            name: 'Test Event',
            date: new EventDate(new DateTimeImmutable('now +1 day')),
            price: new Price(100),
            documentPath: '',
        );
    });
});
