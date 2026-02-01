<?php declare(strict_types = 1);

namespace App\Domain\User\Command\Create;

final readonly class CreateUserCommand
{

	public function __construct(
		public string $email,
		public string $name,
		public int $state = 0,
	)
	{
	}

}
