<?php declare(strict_types = 1);

namespace Tests\E2E\Api\User;

use App\Domain\User\Database\User;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Psr7\Utils;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class CreateUserTest extends ApiTestCase
{

	public function testCreate(): void
	{
		$request = new ServerRequest(
			method: 'POST',
			url: 'http://localhost/v1/user',
			headers: [],
			body: Utils::streamFor(Json::encode([
				'email' => 'newuser@example.com',
				'name' => 'New User',
				'state' => User::STATE_ACTIVE,
			])),
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertArrayHasKey('data', $body);

		$user = $body['data'];
		$this->assertNotEmpty($user['id']);
		$this->assertEquals('newuser@example.com', $user['email']);
		$this->assertEquals('New User', $user['name']);
		$this->assertEquals(User::STATE_ACTIVE, $user['state']);
		$this->assertNotEmpty($user['createdAt']);
		$this->assertNotEmpty($user['updatedAt']);
	}

	protected function load(EntityManagerInterface $em): void
	{
		// No initial data needed for create test
	}

}
