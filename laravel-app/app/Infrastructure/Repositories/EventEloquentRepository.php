<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Event;
use App\Domain\Repository\EventRepositoryInterface;
use App\Domain\ValueObjects\EventDate;
use App\Domain\ValueObjects\Identifier;
use App\Domain\ValueObjects\Price;
use App\Infrastructure\Models\Event as EventModel;

class EventEloquentRepository implements EventRepositoryInterface
{
    public function save(Event $event): void
    {
        EventModel::create([
            'id' => $event->id()->value(),
            'name' => $event->name(),
            'date' => $event->date()->value()->format('Y-m-d'),
            'price' => $event->price()->amountInCents(),
            'currency' => $event->price()->currency(),
            'document_path' => $event->documentPath(),
        ]);
    }

    public function findById(string $id): Event
    {
        $event = EventModel::findOrFail($id);

        return Event::create(
            id: Identifier::create($event->id),
            name: $event->name,
            date: new EventDate($event->date),
            price: new Price($event->price, $event->currency),
            documentPath: $event->document_path,
        );
    }
}
