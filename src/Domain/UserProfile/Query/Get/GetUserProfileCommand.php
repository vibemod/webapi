<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Query\Get;

final readonly class GetUserProfileCommand
{

	public function __construct(
		public string $id,
	)
	{
	}

}
