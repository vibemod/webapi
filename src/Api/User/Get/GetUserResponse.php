<?php declare(strict_types = 1);

namespace App\Api\User\Get;

use App\Domain\User\Query\Get\GetUserResult;
use Contributte\FrameX\Http\EntityResponse;

/**
 * @extends EntityResponse<array{
 *     id: string,
 *     email: string,
 *     name: string,
 *     state: int,
 *     createdAt: string,
 *     updatedAt: string
 * }>
 */
final class GetUserResponse extends EntityResponse
{

	public static function of(GetUserResult $result): self
	{
		$user = $result->user;
		$self = new self();
		$self->payload = [
			'id' => $user->getId(),
			'email' => $user->email,
			'name' => $user->name,
			'state' => $user->state,
			'createdAt' => $user->createdAt->format('Y-m-d\TH:i:s.u\Z'),
			'updatedAt' => $user->updatedAt->format('Y-m-d\TH:i:s.u\Z'),
		];

		return $self;
	}

}
