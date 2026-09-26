<?php

declare(strict_types=1);

use App\Domain\Entities\Event;
use App\Domain\Repository\EventRepositoryInterface;
use App\Domain\ValueObjects\EventDate;
use App\Domain\ValueObjects\Price;
use Faker\Provider\Uuid;

describe('EventRepository', function (): void {
    it('should save an event', function (): void {
        $event = Event::create(
            id: Uuid::uuid(),
            name: 'Test Event',
            date: new EventDate(new DateTimeImmutable('now + 1 day')),
            price: new Price(10000),
        );

        $repository = app(EventRepositoryInterface::class);
        $repository->save($event);

        $this->assertDatabaseHas('events', [
            'id' => $event->id(),
            'name' => $event->name(),
            'date' => $event->date()->value()->format('Y-m-d'),
            'price' => $event->price()->amountInCents(),
            'currency' => $event->price()->currency(),
            'document_path' => $event->documentPath(),
        ]);
    });
});
