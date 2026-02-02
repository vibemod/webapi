<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Create;

use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class CreateUserProfileRequest implements SchemaInterface
{

	public function __construct(
		public readonly CreateUserProfileRequestBody $body,
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
				'userId' => Expect::string()->required(),
				'firstName' => Expect::string()->required(),
				'lastName' => Expect::string()->required(),
				'phone' => Expect::string()->nullable(),
				'avatar' => Expect::string()->nullable(),
				'bio' => Expect::string()->nullable(),
				'dateOfBirth' => Expect::string()->nullable(),
				'gender' => Expect::string()->nullable(),
				'locale' => Expect::string()->nullable(),
			])->castTo(CreateUserProfileRequestBody::class),
		];
	}

}
