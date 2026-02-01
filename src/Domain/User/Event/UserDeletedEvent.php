<?php declare(strict_types = 1);

namespace App\Domain\User\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class UserDeletedEvent extends Event
{

	public function __construct(
		public readonly string $id,
	)
	{
	}

}
