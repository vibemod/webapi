<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Command\Create;

use App\Domain\UserProfile\Database\UserProfile;

final readonly class CreateUserProfileResult
{

	public function __construct(
		public UserProfile $userProfile,
	)
	{
	}

}
