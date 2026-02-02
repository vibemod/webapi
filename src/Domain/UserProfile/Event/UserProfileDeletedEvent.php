<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class UserProfileDeletedEvent extends Event
{

	public function __construct(
		public readonly string $id,
	)
	{
	}

}
