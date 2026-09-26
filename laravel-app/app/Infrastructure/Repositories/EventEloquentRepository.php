<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Event;
use App\Domain\Repository\EventRepositoryInterface;
use App\Infrastructure\Models\Event as EventModel;

class EventEloquentRepository implements EventRepositoryInterface
{
    public function save(Event $event): void
    {
        EventModel::create([
            'id' => $event->id(),
            'name' => $event->name(),
            'date' => $event->date()->value()->format('Y-m-d'),
            'price' => $event->price()->amountInCents(),
            'currency' => $event->price()->currency(),
            'document_path' => $event->documentPath(),
        ]);
    }

    public function findById(string $id): ?Event
    {
        return EventModel::findOrFail($id);
    }
}
