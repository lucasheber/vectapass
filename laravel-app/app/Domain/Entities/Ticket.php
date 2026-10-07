<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Identifier;
use DomainException;

final class Ticket
{
    private function __construct(private Identifier $id, private Identifier $eventId) {}

    public static function create(Identifier $id, Identifier $eventId): self
    {
        return new self($id, $eventId);
    }

    public function id(): Identifier
    {
        return $this->id;
    }

    public function eventId(): Identifier
    {
        return $this->eventId;
    }
}
