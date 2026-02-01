<?php declare(strict_types = 1);

namespace App\Api\User\Update;

use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class UpdateUserRequest implements SchemaInterface
{

	/**
	 * @param array<string, string> $params
	 */
	public function __construct(
		public readonly array $params,
		public readonly UpdateUserRequestBody $body,
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
			'body' => Expect::structure([
				'email' => Expect::string(),
				'name' => Expect::string(),
				'state' => Expect::int(),
			])->castTo(UpdateUserRequestBody::class),
		];
	}

}
