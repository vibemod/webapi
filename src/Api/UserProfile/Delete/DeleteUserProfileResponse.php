<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Delete;

use Contributte\FrameX\Http\EntityResponse;

/**
 * @extends EntityResponse<null>
 */
final class DeleteUserProfileResponse extends EntityResponse
{

	public static function of(): self
	{
		$self = new self();
		$self->payload = null;

		return $self;
	}

}
