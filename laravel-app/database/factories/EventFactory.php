<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Infrastructure\Models\Event;
use DateTimeImmutable;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Uuid::uuid(),
            'name' => fake()->name(),
            'date' => (new DateTimeImmutable('now + 1 day'))->format('Y-m-d'),
            'price' => fake()->numberBetween(10000, 100000),
            'currency' => fake()->randomElement(['BRL', 'USD', 'EUR']),
            'document_path' => fake()->filePath(),
        ];
    }
}
