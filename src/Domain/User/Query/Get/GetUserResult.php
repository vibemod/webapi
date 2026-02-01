<?php declare(strict_types = 1);

namespace App\Domain\User\Query\Get;

use App\Domain\User\Database\User;

final readonly class GetUserResult
{

	public function __construct(
		public User $user,
	)
	{
	}

}
