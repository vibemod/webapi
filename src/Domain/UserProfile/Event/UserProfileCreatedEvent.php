<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Event;

use App\Domain\UserProfile\Database\UserProfile;
use Symfony\Contracts\EventDispatcher\Event;

final class UserProfileCreatedEvent extends Event
{

	public function __construct(
		public readonly UserProfile $userProfile,
	)
	{
	}

}
