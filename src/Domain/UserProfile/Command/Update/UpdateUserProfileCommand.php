<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Command\Update;

final readonly class UpdateUserProfileCommand
{

	public function __construct(
		public string $id,
		public string | null $firstName = null,
		public string | null $lastName = null,
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
