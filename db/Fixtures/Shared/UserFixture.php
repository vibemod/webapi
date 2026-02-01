<?php declare(strict_types = 1);

namespace Database\Fixtures\Shared;

use App\Domain\User\Database\User;
use Database\Fixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{

	public function getOrder(): int
	{
		return 1;
	}

	public function load(ObjectManager $manager): void
	{
		$users = [
			[
				'id' => '11111111-1111-1111-1111-111111111111',
				'email' => 'john@example.com',
				'name' => 'John Doe',
				'state' => User::STATE_ACTIVE,
			],
			[
				'id' => '22222222-2222-2222-2222-222222222222',
				'email' => 'jane@example.com',
				'name' => 'Jane Smith',
				'state' => User::STATE_ACTIVE,
			],
			[
				'id' => '33333333-3333-3333-3333-333333333333',
				'email' => 'inactive@example.com',
				'name' => 'Inactive User',
				'state' => User::STATE_INACTIVE,
			],
		];

		foreach ($users as $userData) {
			$entity = $manager->find(User::class, $userData['id']);
			if ($entity === null) {
				$entity = new User(
					id: $userData['id'],
					email: $userData['email'],
					name: $userData['name'],
					state: $userData['state'],
				);
				$manager->persist($entity);
			} else {
				$entity->email = $userData['email'];
				$entity->name = $userData['name'];
				$entity->state = $userData['state'];
			}
		}

		$manager->flush();
	}

}
