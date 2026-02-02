<?php declare(strict_types = 1);

namespace Tests\E2E\Api\UserProfile;

use App\Domain\User\Database\User;
use App\Domain\UserProfile\Database\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class ListUserProfileTest extends ApiTestCase
{

	public function testList(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user-profile',
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(2, $body['data']);
		$this->assertEquals(2, $body['meta']['count']);
		$this->assertEquals(1, $body['meta']['page']);
		$this->assertEquals(1000, $body['meta']['limit']);
	}

	public function testListFilterByUserId(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user-profile',
		);
		$request = $request->withQueryParams(['q' => ['userId' => '11111111-1111-1111-1111-111111111111']]);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(1, $body['data']);
		$this->assertEquals(1, $body['meta']['count']);
		$this->assertEquals('11111111-1111-1111-1111-111111111111', $body['data'][0]['userId']);
	}

	public function testListOrderByCreatedAtDesc(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user-profile',
		);
		$request = $request->withQueryParams(['o' => ['createdAt' => 'DESC']]);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(2, $body['data']);

		// Verify ordering - newest first
		$profiles = $body['data'];
		for ($i = 0; $i < count($profiles) - 1; $i++) {
			$this->assertGreaterThanOrEqual(
				$profiles[$i + 1]['createdAt'],
				$profiles[$i]['createdAt']
			);
		}
	}

	public function testListWithPagination(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user-profile',
		);
		$request = $request->withQueryParams(['l' => '1']);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertCount(1, $body['data']);
		$this->assertEquals(2, $body['meta']['count']);
		$this->assertEquals(1, $body['meta']['limit']);
	}

	protected function load(EntityManagerInterface $em): void
	{
		$user1 = new User(
			id: '11111111-1111-1111-1111-111111111111',
			email: 'john@example.com',
			name: 'John Doe',
			state: User::STATE_ACTIVE
		);
		$em->persist($user1);

		$user2 = new User(
			id: '22222222-2222-2222-2222-222222222222',
			email: 'jane@example.com',
			name: 'Jane Smith',
			state: User::STATE_ACTIVE
		);
		$em->persist($user2);

		$profile1 = new UserProfile(
			id: 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa',
			user: $user1,
			firstName: 'John',
			lastName: 'Doe',
		);
		$em->persist($profile1);

		$profile2 = new UserProfile(
			id: 'bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbb',
			user: $user2,
			firstName: 'Jane',
			lastName: 'Smith',
		);
		$em->persist($profile2);

		$em->flush();
	}

}
