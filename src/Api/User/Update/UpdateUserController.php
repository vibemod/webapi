<?php declare(strict_types = 1);

namespace App\Api\User\Update;

use App\Api\BetterApiController;
use App\Domain\User\Command\Update\UpdateUserCommand;
use App\Domain\User\Command\Update\UpdateUserResult;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class UpdateUserController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly CommandBus $commandBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): UpdateUserResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, UpdateUserRequest::class);

		$result = $this->commandBus->typedHandle(
			new UpdateUserCommand(
				id: $request->params['id'],
				email: $request->body->email,
				name: $request->body->name,
				state: $request->body->state,
			),
			UpdateUserResult::class
		);

		return UpdateUserResponse::of($result);
	}

}
