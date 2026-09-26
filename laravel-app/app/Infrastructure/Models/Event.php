<?php

declare(strict_types=1);

namespace App\Infrastructure\Models;

use Database\Factories\EventFactory;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $name
 * @property DateTimeImmutable $date
 * @property int $price
 * @property string $currency
 * @property string|null $document_path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
#[UseFactory(EventFactory::class)]
#[Fillable(['id', 'name', 'date', 'price', 'currency', 'document_path'])]
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    /**
     * @return Attribute<DateTimeImmutable, string>
     */
    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn (string $value): DateTimeImmutable => new DateTimeImmutable($value),
            set: fn (DateTimeImmutable|string $value): string => $value instanceof DateTimeImmutable
                ? $value->format('Y-m-d')
                : $value,
        );
    }
}
