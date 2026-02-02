<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Create;

use App\Api\BetterApiController;
use App\Domain\UserProfile\Command\Create\CreateUserProfileCommand;
use App\Domain\UserProfile\Command\Create\CreateUserProfileResult;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class CreateUserProfileController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly CommandBus $commandBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): CreateUserProfileResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, CreateUserProfileRequest::class);

		$result = $this->commandBus->typedHandle(
			new CreateUserProfileCommand(
				userId: $request->body->userId,
				firstName: $request->body->firstName,
				lastName: $request->body->lastName,
				phone: $request->body->phone,
				avatar: $request->body->avatar,
				bio: $request->body->bio,
				dateOfBirth: $request->body->dateOfBirth,
				gender: $request->body->gender,
				locale: $request->body->locale,
			),
			CreateUserProfileResult::class
		);

		return CreateUserProfileResponse::of($result);
	}

}
