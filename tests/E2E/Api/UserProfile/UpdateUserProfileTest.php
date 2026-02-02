<?php declare(strict_types = 1);

namespace Tests\E2E\Api\UserProfile;

use App\Domain\User\Database\User;
use App\Domain\UserProfile\Database\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Psr7\Utils;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class UpdateUserProfileTest extends ApiTestCase
{

	public function testUpdate(): void
	{
		$request = new ServerRequest(
			method: 'PUT',
			url: 'http://localhost/v1/user-profile/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa',
			headers: [],
			body: Utils::streamFor(Json::encode([
				'firstName' => 'Updated',
				'lastName' => 'Name',
				'phone' => '+9876543210',
				'bio' => 'Updated bio',
				'gender' => 'female',
				'locale' => 'de_DE',
			])),
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);

		$profile = $body['data'];
		$this->assertEquals('aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa', $profile['id']);
		$this->assertEquals('Updated', $profile['firstName']);
		$this->assertEquals('Name', $profile['lastName']);
		$this->assertEquals('+9876543210', $profile['phone']);
		$this->assertEquals('Updated bio', $profile['bio']);
		$this->assertEquals('female', $profile['gender']);
		$this->assertEquals('de_DE', $profile['locale']);
	}

	public function testUpdateNotFound(): void
	{
		$request = new ServerRequest(
			method: 'PUT',
			url: 'http://localhost/v1/user-profile/99999999-9999-9999-9999-999999999999',
			headers: [],
			body: Utils::streamFor(Json::encode([
				'firstName' => 'Updated',
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
