<?php declare(strict_types = 1);

namespace App\Api\UserProfile\List;

use App\Domain\UserProfile\DTO\UserProfileRowDto;
use App\Domain\UserProfile\Query\List\ListUserProfileResult;
use Contributte\FrameX\Http\EntityListResponse;

/**
 * @extends EntityListResponse<UserProfileRowDto>
 */
final class ListUserProfileResponse extends EntityListResponse
{

	public static function of(ListUserProfileResult $result): self
	{
		$self = self::create();

		$self->entities = $result->entities;
		$self->count = $result->count;
		$self->limit = $result->limit;
		$self->page = $result->page;

		return $self;
	}

}
