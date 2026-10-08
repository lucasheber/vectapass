<?php

declare(strict_types=1);

namespace Tests\Support;

use App\Domain\Entities\Event;
use App\Domain\Repository\EventRepositoryInterface;

class FakeEventRepository implements EventRepositoryInterface
{
    private array $events = [];

    public function save(Event $event): void
    {
        $this->events[$event->id()->value()] = $event;
    }

    public function findById(string $id): ?Event
    {
        return $this->events[$id] ?? null;
    }
}
