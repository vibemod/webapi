<?php

declare(strict_types = 1);

namespace App\Api\Acme\Delete;

use Contributte\FrameX\Http\EntityResponse;

/**
 * @extends EntityResponse<null>
 */
final class DeleteAcmeResponse extends EntityResponse
{

    public static function of(): self
    {
        $self = new self();
        $self->payload = null;

        return $self;
    }

}
