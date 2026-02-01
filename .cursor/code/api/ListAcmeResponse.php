<?php

declare(strict_types = 1);

namespace App\Api\Acme\List;

use App\Domain\Acme\DTO\AcmeRowDto;
use App\Domain\Acme\Query\List\ListAcmeResult;
use Contributte\FrameX\Http\EntityListResponse;

/**
 * @extends EntityListResponse<AcmeRowDto>
 */
final class ListAcmeResponse extends EntityListResponse
{

    public static function of(ListAcmeResult $result): self
    {
        $self = self::create();

        $self->entities = $result->entities;
        $self->count = $result->count;
        $self->limit = $result->limit;
        $self->page = $result->page;

        return $self;
    }

}
