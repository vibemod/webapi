<?php declare(strict_types = 1);

namespace App\Domain\User\Command\Create;

use App\Domain\User\Database\User;

final readonly class CreateUserResult
{

	public function __construct(
		public User $user,
	)
	{
	}

}
