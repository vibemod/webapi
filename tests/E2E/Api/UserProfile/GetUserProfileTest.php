<?php declare(strict_types = 1);

namespace Tests\E2E\Api\UserProfile;

use App\Domain\User\Database\User;
use App\Domain\UserProfile\Database\UserProfile;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class GetUserProfileTest extends ApiTestCase
{

	public function testGet(): void
	{
		$request = new ServerRequest(
			method: 'GET',
			url: 'http://localhost/v1/user-profile/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa',
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);

		$profile = $body['data'];
		$this->assertEquals('aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa', $profile['id']);
		$this->assertEquals('11111111-1111-1111-1111-111111111111', $profile['userId']);
		$this->assertEquals('John', $profile['firstName']);
		$this->assertEquals('Doe', $profile['lastName']);
		$this->assertEquals('+1234567890', $profile['phone']);
		$this->assertEquals('1990-01-15', $profile['dateOfBirth']);
		$this->assertEquals('male', $profile['gender']);
		$this->assertEquals('en_US', $profile['locale']);
	}

	public function testGetNotFound(): void
	{
		$request = new ServerRequest(
			method: 'GET',
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
			phone: '+1234567890',
			dateOfBirth: new DateTime('1990-01-15'),
			gender: 'male',
			locale: 'en_US',
		);
		$em->persist($profile);
		$em->flush();
	}

}
