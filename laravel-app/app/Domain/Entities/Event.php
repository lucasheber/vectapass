<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\EventDate;
use App\Domain\ValueObjects\Identifier;
use App\Domain\ValueObjects\Price;
use DomainException;

final readonly class Event
{
    private function __construct(
        private Identifier $id,
        private string $name,
        private EventDate $date,
        private Price $price,
        private ?string $documentPath,
    ) {
        $this->validate();
    }

    public static function create(
        Identifier $id,
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
        if ($this->name === '') {
            throw new DomainException('The event name is required.');
        }

        if ($this->documentPath === '') {
            throw new DomainException('The document path cannot be empty.');
        }
    }

    public function id(): Identifier
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
