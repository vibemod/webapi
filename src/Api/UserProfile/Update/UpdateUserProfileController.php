<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Update;

use App\Api\BetterApiController;
use App\Domain\UserProfile\Command\Update\UpdateUserProfileCommand;
use App\Domain\UserProfile\Command\Update\UpdateUserProfileResult;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class UpdateUserProfileController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly CommandBus $commandBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): UpdateUserProfileResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, UpdateUserProfileRequest::class);

		$result = $this->commandBus->typedHandle(
			new UpdateUserProfileCommand(
				id: $request->params['id'],
				firstName: $request->body->firstName,
				lastName: $request->body->lastName,
				phone: $request->body->phone,
				avatar: $request->body->avatar,
				bio: $request->body->bio,
				dateOfBirth: $request->body->dateOfBirth,
				gender: $request->body->gender,
				locale: $request->body->locale,
			),
			UpdateUserProfileResult::class
		);

		return UpdateUserProfileResponse::of($result);
	}

}
