<?php declare(strict_types = 1);

namespace Tests\E2E\Api\User;

use App\Domain\User\Database\User;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class GetUserTest extends ApiTestCase
{

	public function testGet(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user/11111111-1111-1111-1111-111111111111',
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);

		$user = $body['data'];
		$this->assertEquals('11111111-1111-1111-1111-111111111111', $user['id']);
		$this->assertEquals('john@example.com', $user['email']);
		$this->assertEquals('John Doe', $user['name']);
		$this->assertEquals(User::STATE_ACTIVE, $user['state']);
	}

	public function testGetNotFound(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user/99999999-9999-9999-9999-999999999999',
		);

		$response = $this->dispatch($request);

		$this->assertEquals(404, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('error', $body['status']);
	}

	protected function load(EntityManagerInterface $em): void
	{
		$user = new User(
			id: '11111111-1111-1111-1111-111111111111',
			email: 'john@example.com',
			name: 'John Doe',
			state: User::STATE_ACTIVE
		);
		$em->persist($user);
		$em->flush();
	}

}
