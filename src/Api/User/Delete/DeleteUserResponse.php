<?php declare(strict_types = 1);

namespace App\Api\User\Delete;

use Contributte\FrameX\Http\EntityResponse;

/**
 * @extends EntityResponse<null>
 */
final class DeleteUserResponse extends EntityResponse
{

	public static function of(): self
	{
		$self = new self();
		$self->payload = null;

		return $self;
	}

}
