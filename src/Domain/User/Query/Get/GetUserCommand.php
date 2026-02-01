<?php declare(strict_types = 1);

namespace App\Domain\User\Query\Get;

final readonly class GetUserCommand
{

	public function __construct(
		public string $id,
	)
	{
	}

}
