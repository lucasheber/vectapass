<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\EventDate;
use App\Domain\ValueObjects\Price;
use DomainException;

final readonly class Event
{
    private const UUID_PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-8][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

    private function __construct(
        private string $id,
        private string $name,
        private EventDate $date,
        private Price $price,
        private ?string $documentPath,
    ) {
        $this->validate();
    }

    public static function create(
        string $id,
        string $name,
        EventDate $date,
        Price $price,
        ?string $documentPath = null,
    ): self {
        return new self(
            $id,
            trim($name),
            $date,
            $price,
            self::normalizeDocumentPath($documentPath),
        );
    }

    public function validate(): void
    {
        if (preg_match(self::UUID_PATTERN, $this->id) !== 1) {
            throw new DomainException('The event identifier must be a valid UUID.');
        }

        if ($this->name === '') {
            throw new DomainException('The event name is required.');
        }

        if ($this->documentPath === '') {
            throw new DomainException('The document path cannot be empty.');
        }
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function date(): EventDate
    {
        return $this->date;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function documentPath(): ?string
    {
        return $this->documentPath;
    }

    private static function normalizeDocumentPath(?string $documentPath): ?string
    {
        if ($documentPath === null) {
            return null;
        }

        return trim($documentPath);
    }
}
