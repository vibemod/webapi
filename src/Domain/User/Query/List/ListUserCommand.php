<?php declare(strict_types = 1);

namespace App\Domain\User\Query\List;

use Nettrine\Extra\Data\QueryFilter;

final readonly class ListUserCommand
{

	public function __construct(
		public QueryFilter $filter
	)
	{
	}

}
