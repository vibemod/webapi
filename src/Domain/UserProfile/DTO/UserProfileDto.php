<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\DTO;

use App\Domain\UserProfile\Database\UserProfile;

final readonly class UserProfileDto
{

	public function __construct(
		public string $id,
		public string $userId,
		public string $firstName,
		public string $lastName,
		public string | null $phone,
		public string | null $avatar,
		public string | null $bio,
		public string | null $dateOfBirth,
		public string | null $gender,
		public string | null $locale,
		public string $createdAt,
		public string $updatedAt,
	)
	{
	}

	public static function fromEntity(UserProfile $profile): self
	{
		return new self(
			id: $profile->getId(),
			userId: $profile->user->getId(),
			firstName: $profile->firstName,
			lastName: $profile->lastName,
			phone: $profile->phone,
			avatar: $profile->avatar,
			bio: $profile->bio,
			dateOfBirth: $profile->dateOfBirth?->format('Y-m-d'),
			gender: $profile->gender,
			locale: $profile->locale,
			createdAt: $profile->createdAt->format('Y-m-d\TH:i:s.u\Z'),
			updatedAt: $profile->updatedAt->format('Y-m-d\TH:i:s.u\Z'),
		);
	}

}
