<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Update;

use App\Domain\UserProfile\Command\Update\UpdateUserProfileResult;
use Contributte\FrameX\Http\EntityResponse;

/**
 * @extends EntityResponse<array{
 *     id: string,
 *     userId: string,
 *     firstName: string,
 *     lastName: string,
 *     phone: string|null,
 *     avatar: string|null,
 *     bio: string|null,
 *     dateOfBirth: string|null,
 *     gender: string|null,
 *     locale: string|null,
 *     createdAt: string,
 *     updatedAt: string
 * }>
 */
final class UpdateUserProfileResponse extends EntityResponse
{

	public static function of(UpdateUserProfileResult $result): self
	{
		$profile = $result->userProfile;
		$self = new self();
		$self->payload = [
			'id' => $profile->getId(),
			'userId' => $profile->user->getId(),
			'firstName' => $profile->firstName,
			'lastName' => $profile->lastName,
			'phone' => $profile->phone,
			'avatar' => $profile->avatar,
			'bio' => $profile->bio,
			'dateOfBirth' => $profile->dateOfBirth?->format('Y-m-d'),
			'gender' => $profile->gender,
			'locale' => $profile->locale,
			'createdAt' => $profile->createdAt->format('Y-m-d\TH:i:s.u\Z'),
			'updatedAt' => $profile->updatedAt->format('Y-m-d\TH:i:s.u\Z'),
		];

		return $self;
	}

}
