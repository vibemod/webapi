<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Command\Update;

use App\Domain\UserProfile\Database\UserProfile;

final readonly class UpdateUserProfileResult
{

	public function __construct(
		public UserProfile $userProfile,
	)
	{
	}

}
