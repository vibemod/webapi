<?php declare(strict_types = 1);

namespace App\Domain\User\Command\Update;

final readonly class UpdateUserCommand
{

	public function __construct(
		public string $id,
		public string | null $email = null,
		public string | null $name = null,
		public int | null $state = null,
	)
	{
	}

}
