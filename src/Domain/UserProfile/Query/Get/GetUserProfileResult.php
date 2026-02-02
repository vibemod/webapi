<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Query\Get;

use App\Domain\UserProfile\Database\UserProfile;

final readonly class GetUserProfileResult
{

	public function __construct(
		public UserProfile $userProfile,
	)
	{
	}

}
