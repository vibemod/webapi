<?php

declare(strict_types = 1);

namespace App\Domain\Acme\DTO;

use App\Domain\Acme\Database\Acme;

final readonly class AcmeDto
{

    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }

    public static function fromEntity(Acme $acme): self
    {
        return new self(
            id: $acme->getId(),
            name: $acme->name,
            description: $acme->description,
            createdAt: $acme->createdAt->format('Y-m-d\TH:i:s.u\Z'),
            updatedAt: $acme->updatedAt->format('Y-m-d\TH:i:s.u\Z'),
        );
    }

}
