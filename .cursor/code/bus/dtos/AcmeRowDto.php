<?php

declare(strict_types = 1);

namespace App\Domain\Acme\DTO;

final readonly class AcmeRowDto
{
    public function __construct(
        public string $id,
    ) {
        // No-op
    }

    /**
     * @phpstan-param array{
     *     id: string,
     * } $row
     */
    public static function fromRow(array $row): self
    {
        return new self(
            id: $row['id'],
        );
    }
}
