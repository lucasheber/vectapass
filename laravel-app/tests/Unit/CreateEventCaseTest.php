<?php

declare(strict_types=1);

use App\Application\UseCases\CreateEventUseCase;
use App\Domain\Entities\Event;
use Tests\Support\FakeEventRepository;

describe('CreateEventCase', function (): void {
    it('should create an event', function (): void {
        $repository = new FakeEventRepository;
        $useCase = new CreateEventUseCase($repository);
        $date = date('Y-m-d', strtotime('now +1 day'));

        $event = $useCase->execute(
            name: 'Event 1',
            date: $date,
            price: 100,
            currency: 'USD',
        );

        $eventFake = $repository->findById($event->id()->value());
        expect($eventFake)->toBeInstanceOf(Event::class);
        expect($eventFake->name())->toBe('Event 1');
        expect($eventFake->date()->value()->format('Y-m-d'))->toBe($date);
        expect($eventFake->price()->amountInCents())->toBe(100);
        expect($eventFake->documentPath())->toBeNull();
        expect($eventFake->price()->currency())->toBe('USD');
    });
});
