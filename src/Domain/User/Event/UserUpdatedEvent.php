<?php declare(strict_types = 1);

namespace App\Domain\User\Event;

use App\Domain\User\Database\User;
use Symfony\Contracts\EventDispatcher\Event;

final class UserUpdatedEvent extends Event
{

	public function __construct(
		public readonly User $user,
	)
	{
	}

}
