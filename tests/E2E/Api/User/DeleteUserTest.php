<?php declare(strict_types = 1);

namespace Tests\E2E\Api\User;

use App\Domain\User\Database\User;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class DeleteUserTest extends ApiTestCase
{

	public function testDelete(): void
	{
		$request = new ServerRequest(
			method: 'DELETE',
			url: 'http://localhost/v1/user/33333333-3333-3333-3333-333333333333',
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);

		// Verify user is deleted by trying to get it
		$getRequest = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user/33333333-3333-3333-3333-333333333333',
		);

		$getResponse = $this->dispatch($getRequest);
		$this->assertEquals(404, $getResponse->getStatusCode());
	}

	public function testDeleteNotFound(): void
	{
		$request = new ServerRequest(
			method: 'DELETE',
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
			id: '33333333-3333-3333-3333-333333333333',
			email: 'inactive@example.com',
			name: 'Inactive User',
			state: User::STATE_INACTIVE
		);
		$em->persist($user);
		$em->flush();
	}

}
