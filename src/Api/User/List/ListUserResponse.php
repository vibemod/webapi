<?php declare(strict_types = 1);

namespace App\Api\User\List;

use App\Domain\User\DTO\UserRowDto;
use App\Domain\User\Query\List\ListUserResult;
use Contributte\FrameX\Http\EntityListResponse;

/**
 * @extends EntityListResponse<UserRowDto>
 */
final class ListUserResponse extends EntityListResponse
{

	public static function of(ListUserResult $result): self
	{
		$self = self::create();

		$self->entities = $result->entities;
		$self->count = $result->count;
		$self->limit = $result->limit;
		$self->page = $result->page;

		return $self;
	}

}
