<?php

declare(strict_types = 1);

namespace App\Api\Acme\Update;

use App\Domain\Acme\DTO\AcmeDto;
use Contributte\FrameX\Http\EntityResponse;

/**
 * @extends EntityResponse<array{
 *     id: string,
 *     name: string,
 *     description: string,
 *     createdAt: string,
 *     updatedAt: string
 * }>
 */
final class UpdateAcmeResponse extends EntityResponse
{

    public static function of(AcmeDto $acme): self
    {
        $self = new self();
        $self->payload = [
            'id' => $acme->id,
            'name' => $acme->name,
            'description' => $acme->description,
            'createdAt' => $acme->createdAt,
            'updatedAt' => $acme->updatedAt,
        ];

        return $self;
    }

}
