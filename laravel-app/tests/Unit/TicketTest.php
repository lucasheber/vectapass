<?php

declare(strict_types=1);

use App\Domain\Entities\Ticket;
use App\Domain\ValueObjects\Identifier;
use Faker\Provider\Uuid;

describe('Ticket', function (): void {
    it('should create a ticket', function (): void {
        $id = Identifier::create(Uuid::uuid());
        $eventId = Identifier::create(Uuid::uuid());
        $ticket = Ticket::create($id, $eventId);
        expect($ticket->id()->value())->toBe($id->value());
        expect($ticket->eventId())->toBe($eventId);
    });
});
