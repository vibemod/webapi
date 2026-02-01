<?php declare(strict_types = 1);

namespace Tests\E2E\Api\User;

use App\Domain\User\Database\User;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Psr7\Utils;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class UpdateUserTest extends ApiTestCase
{

	public function testUpdate(): void
	{
		$request = new ServerRequest(
			method: 'PUT',
			url: 'http://localhost/v1/user/11111111-1111-1111-1111-111111111111',
			headers: [],
			body: Utils::streamFor(Json::encode([
				'email' => 'updated@example.com',
				'name' => 'Updated User',
				'state' => User::STATE_INACTIVE,
			])),
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);

		$user = $body['data'];
		$this->assertEquals('11111111-1111-1111-1111-111111111111', $user['id']);
		$this->assertEquals('updated@example.com', $user['email']);
		$this->assertEquals('Updated User', $user['name']);
		$this->assertEquals(User::STATE_INACTIVE, $user['state']);
	}

	public function testUpdateNotFound(): void
	{
		$request = new ServerRequest(
			method: 'PUT',
			url: 'http://localhost/v1/user/99999999-9999-9999-9999-999999999999',
			headers: [],
			body: Utils::streamFor(Json::encode([
				'email' => 'updated@example.com',
				'name' => 'Updated User',
				'state' => User::STATE_INACTIVE,
			])),
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
