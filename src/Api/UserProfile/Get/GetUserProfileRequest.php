<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Get;

use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class GetUserProfileRequest implements SchemaInterface
{

	/**
	 * @param array<string, string> $params
	 */
	public function __construct(
		public readonly array $params,
	)
	{
	}

	/**
	 * {@inheritDoc}
	 */
	public static function schema(): array
	{
		return [
			'params' => Expect::structure([
				'id' => Expect::string()->required(),
			])->castTo('array'),
		];
	}

}
