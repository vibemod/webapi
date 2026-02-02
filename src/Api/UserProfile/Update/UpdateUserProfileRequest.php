<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Update;

use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class UpdateUserProfileRequest implements SchemaInterface
{

	/**
	 * @param array<string, string> $params
	 */
	public function __construct(
		public readonly array $params,
		public readonly UpdateUserProfileRequestBody $body,
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
				'firstName' => Expect::string(),
				'lastName' => Expect::string(),
				'phone' => Expect::string()->nullable(),
				'avatar' => Expect::string()->nullable(),
				'bio' => Expect::string()->nullable(),
				'dateOfBirth' => Expect::string()->nullable(),
				'gender' => Expect::string()->nullable(),
				'locale' => Expect::string()->nullable(),
			])->castTo(UpdateUserProfileRequestBody::class),
		];
	}

}
