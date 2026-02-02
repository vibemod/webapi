<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Query\List;

use Nettrine\Extra\Data\QueryFilter;

final readonly class ListUserProfileCommand
{

	public function __construct(
		public QueryFilter $filter
	)
	{
	}

}
