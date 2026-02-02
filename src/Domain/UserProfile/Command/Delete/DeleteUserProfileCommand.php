<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Command\Delete;

final readonly class DeleteUserProfileCommand
{

	public function __construct(
		public string $id,
	)
	{
	}

}
