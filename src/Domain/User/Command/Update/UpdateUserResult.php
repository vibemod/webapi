<?php declare(strict_types = 1);

namespace App\Domain\User\Command\Update;

use App\Domain\User\Database\User;

final readonly class UpdateUserResult
{

	public function __construct(
		public User $user,
	)
	{
	}

}
