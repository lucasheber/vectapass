<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\Event;
use App\Domain\Repository\EventRepositoryInterface;
use App\Domain\ValueObjects\EventDate;
use App\Domain\ValueObjects\Identifier;
use App\Domain\ValueObjects\Price;
use DateTimeImmutable;
use Illuminate\Support\Str;

class CreateEventUseCase
{
    public function __construct(private readonly EventRepositoryInterface $eventRepository) {}

    public function execute(string $name, string $date, int $price, string $currency = 'BRL', ?string $documentPath = null): Event
    {
        $identifier = Identifier::create((string) Str::uuid());
        $eventDate = new EventDate(new DateTimeImmutable($date));
        $priceValue = new Price($price, $currency);

        $event = Event::create(
            id: $identifier,
            name: $name,
            date: $eventDate,
            price: $priceValue,
            documentPath: $documentPath,
        );

        $this->eventRepository->save($event);
        return $event;
    }
}
