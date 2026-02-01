<?php declare(strict_types = 1);

namespace App\Api\User\Create;

use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class CreateUserRequest implements SchemaInterface
{

	public function __construct(
		public readonly CreateUserRequestBody $body,
	)
	{
	}

	/**
	 * {@inheritDoc}
	 */
	public static function schema(): array
	{
		return [
			'body' => Expect::structure([
				'email' => Expect::string()->required(),
				'name' => Expect::string()->required(),
				'state' => Expect::int(0),
			])->castTo(CreateUserRequestBody::class),
		];
	}

}
