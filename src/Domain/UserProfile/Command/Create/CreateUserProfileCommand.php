<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Command\Create;

final readonly class CreateUserProfileCommand
{

	public function __construct(
		public string $userId,
		public string $firstName,
		public string $lastName,
		public string | null $phone = null,
		public string | null $avatar = null,
		public string | null $bio = null,
		public string | null $dateOfBirth = null,
		public string | null $gender = null,
		public string | null $locale = null,
	)
	{
	}

}
