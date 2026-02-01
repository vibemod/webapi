<?php declare(strict_types = 1);

namespace App\Api\User\Create;

use App\Api\BetterApiController;
use App\Domain\User\Command\Create\CreateUserCommand;
use App\Domain\User\Command\Create\CreateUserResult;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class CreateUserController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly CommandBus $commandBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): CreateUserResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, CreateUserRequest::class);

		$result = $this->commandBus->typedHandle(
			new CreateUserCommand(
				email: $request->body->email,
				name: $request->body->name,
				state: $request->body->state,
			),
			CreateUserResult::class
		);

		return CreateUserResponse::of($result);
	}

}
