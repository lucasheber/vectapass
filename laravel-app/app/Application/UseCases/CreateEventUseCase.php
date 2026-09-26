<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\Event;
use App\Domain\Repository\EventRepositoryInterface;
use App\Domain\ValueObjects\EventDate;
use App\Domain\ValueObjects\Price;
use DateTimeImmutable;
use Faker\Provider\Uuid;

class CreateEventUseCase
{
    public function __construct(private readonly EventRepositoryInterface $eventRepository) {}

    public function execute(string $name, string $date, int $price, ?string $documentPath = null): void
    {

        $event = Event::create(
            id: Uuid::uuid(),
            name: $name,
            date: new EventDate(new DateTimeImmutable($date)),
            price: new Price($price),
            documentPath: $documentPath,
        );

        $this->eventRepository->save($event);
    }
}
