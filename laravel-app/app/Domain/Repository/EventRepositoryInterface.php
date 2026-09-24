<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entities\Event;

interface EventRepositoryInterface
{
    public function save(Event $event): void;

    public function findById(string $id): ?Event;
}
