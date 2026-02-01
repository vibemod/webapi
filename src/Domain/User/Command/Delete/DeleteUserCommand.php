<?php declare(strict_types = 1);

namespace App\Domain\User\Command\Delete;

final readonly class DeleteUserCommand
{

	public function __construct(
		public string $id,
	)
	{
	}

}
