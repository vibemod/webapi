<?php declare(strict_types = 1);

namespace App\Api\User\List;

use App\Model\Api\RequestFilter;
use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class ListUserRequest implements SchemaInterface
{

	public function __construct(
		public readonly RequestFilter $query,
	)
	{
	}

	/**
	 * @inheritDoc
	 */
	public static function schema(): array
	{
		return [
			'query' => RequestFilter::extend([
				'o' => Expect::structure([
					'createdAt' => Expect::string()->nullable(),
					'updatedAt' => Expect::string()->nullable(),
				])->required(false)->castTo('array'),
				'q' => Expect::structure([
					'state' => Expect::int()->nullable(),
				])->required(false)->castTo('array'),
			])->castTo(RequestFilter::class),
		];
	}

}
