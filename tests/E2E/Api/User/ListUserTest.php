<?php declare(strict_types = 1);

namespace Tests\E2E\Api\User;

use App\Domain\User\Database\User;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class ListUserTest extends ApiTestCase
{

	public function testList(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user',
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(3, $body['data']);
		$this->assertEquals(3, $body['meta']['count']);
		$this->assertEquals(1, $body['meta']['page']);
		$this->assertEquals(1000, $body['meta']['limit']);
	}

	public function testListFilterByActiveState(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user',
		);
		$request = $request->withQueryParams(['q' => ['state' => User::STATE_ACTIVE]]);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(2, $body['data']);
		$this->assertEquals(2, $body['meta']['count']);

		// Verify all returned users are active
		foreach ($body['data'] as $user) {
			$this->assertEquals(User::STATE_ACTIVE, $user['state']);
		}
	}

	public function testListFilterByInactiveState(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user',
		);
		$request = $request->withQueryParams(['q' => ['state' => User::STATE_INACTIVE]]);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(1, $body['data']);
		$this->assertEquals(1, $body['meta']['count']);

		$user = $body['data'][0];
		$this->assertEquals(User::STATE_INACTIVE, $user['state']);
		$this->assertEquals('inactive@example.com', $user['email']);
	}

	public function testListOrderByCreatedAtDesc(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user',
		);
		$request = $request->withQueryParams(['o' => ['createdAt' => 'DESC']]);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(3, $body['data']);

		// Verify ordering - newest first
		$users = $body['data'];
		for ($i = 0; $i < count($users) - 1; $i++) {
			$this->assertGreaterThanOrEqual(
				$users[$i + 1]['createdAt'],
				$users[$i]['createdAt']
			);
		}
	}

	public function testListOrderByCreatedAtAsc(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user',
		);
		$request = $request->withQueryParams(['o' => ['createdAt' => 'ASC']]);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(3, $body['data']);

		// Verify ordering - oldest first
		$users = $body['data'];
		for ($i = 0; $i < count($users) - 1; $i++) {
			$this->assertLessThanOrEqual(
				$users[$i + 1]['createdAt'],
				$users[$i]['createdAt']
			);
		}
	}

	public function testListWithPagination(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user',
		);
		$request = $request->withQueryParams(['l' => '2']);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(2, $body['data']);
		$this->assertEquals(3, $body['meta']['count']); // Total count should still be 3
		$this->assertEquals(2, $body['meta']['limit']);
	}

	protected function load(EntityManagerInterface $em): void
	{
		// Active user 1
		$user1 = new User(
			id: '11111111-1111-1111-1111-111111111111',
			email: 'john@example.com',
			name: 'John Doe',
			state: User::STATE_ACTIVE
		);
		$em->persist($user1);

		// Active user 2
		$user2 = new User(
			id: '22222222-2222-2222-2222-222222222222',
			email: 'jane@example.com',
			name: 'Jane Smith',
			state: User::STATE_ACTIVE
		);
		$em->persist($user2);

		// Inactive user
		$user3 = new User(
			id: '33333333-3333-3333-3333-333333333333',
			email: 'inactive@example.com',
			name: 'Inactive User',
			state: User::STATE_INACTIVE
		);
		$em->persist($user3);

		$em->flush();
	}

}
