<?php declare(strict_types = 1);

namespace Tests\E2E\Api\UserProfile;

use App\Domain\User\Database\User;
use App\Domain\UserProfile\Database\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class DeleteUserProfileTest extends ApiTestCase
{

	public function testDelete(): void
	{
		$request = new ServerRequest(
			method: 'DELETE',
			url: 'http://localhost/v1/user-profile/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa',
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);

		// Verify profile is deleted by trying to get it
		$getRequest = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user-profile/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa',
		);

		$getResponse = $this->dispatch($getRequest);
		$this->assertEquals(404, $getResponse->getStatusCode());
	}

	public function testDeleteNotFound(): void
	{
		$request = new ServerRequest(
			method: 'DELETE',
			url: 'http://localhost/v1/user-profile/99999999-9999-9999-9999-999999999999',
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

		$profile = new UserProfile(
			id: 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa',
			user: $user,
			firstName: 'John',
			lastName: 'Doe',
		);
		$em->persist($profile);
		$em->flush();
	}

}
