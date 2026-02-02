<?php declare(strict_types = 1);

namespace Tests\E2E\Api\UserProfile;

use App\Domain\User\Database\User;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Psr7\Utils;
use Nette\Utils\Json;
use React\Http\Message\ServerRequest;
use Tests\E2E\ApiTestCase;

final class CreateUserProfileTest extends ApiTestCase
{

	public function testCreate(): void
	{
		$request = new ServerRequest(
			method: 'POST',
			url: 'http://localhost/v1/user-profile',
			headers: [],
			body: Utils::streamFor(Json::encode([
				'userId' => '11111111-1111-1111-1111-111111111111',
				'firstName' => 'John',
				'lastName' => 'Doe',
				'phone' => '+1234567890',
				'avatar' => 'https://example.com/avatar.jpg',
				'bio' => 'A short bio',
				'dateOfBirth' => '1990-01-15',
				'gender' => 'male',
				'locale' => 'en_US',
			])),
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);
		$this->assertArrayHasKey('data', $body);

		$profile = $body['data'];
		$this->assertNotEmpty($profile['id']);
		$this->assertEquals('11111111-1111-1111-1111-111111111111', $profile['userId']);
		$this->assertEquals('John', $profile['firstName']);
		$this->assertEquals('Doe', $profile['lastName']);
		$this->assertEquals('+1234567890', $profile['phone']);
		$this->assertEquals('https://example.com/avatar.jpg', $profile['avatar']);
		$this->assertEquals('A short bio', $profile['bio']);
		$this->assertEquals('1990-01-15', $profile['dateOfBirth']);
		$this->assertEquals('male', $profile['gender']);
		$this->assertEquals('en_US', $profile['locale']);
		$this->assertNotEmpty($profile['createdAt']);
		$this->assertNotEmpty($profile['updatedAt']);
	}

	public function testCreateMinimal(): void
	{
		$request = new ServerRequest(
			method: 'POST',
			url: 'http://localhost/v1/user-profile',
			headers: [],
			body: Utils::streamFor(Json::encode([
				'userId' => '11111111-1111-1111-1111-111111111111',
				'firstName' => 'Jane',
				'lastName' => 'Smith',
			])),
		);

		$response = $this->dispatch($request);

		$this->assertEquals(200, $response->getStatusCode());

		$body = Json::decode($response->getBody()->getContents(), true);
		$this->assertEquals('ok', $body['status']);

		$profile = $body['data'];
		$this->assertEquals('Jane', $profile['firstName']);
		$this->assertEquals('Smith', $profile['lastName']);
		$this->assertNull($profile['phone']);
		$this->assertNull($profile['avatar']);
		$this->assertNull($profile['bio']);
		$this->assertNull($profile['dateOfBirth']);
		$this->assertNull($profile['gender']);
		$this->assertNull($profile['locale']);
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
