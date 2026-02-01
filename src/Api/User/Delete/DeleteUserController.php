<?php declare(strict_types = 1);

namespace App\Api\User\Delete;

use App\Api\BetterApiController;
use App\Domain\User\Command\Delete\DeleteUserCommand;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class DeleteUserController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly CommandBus $commandBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): DeleteUserResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, DeleteUserRequest::class);

		$this->commandBus->handle(
			new DeleteUserCommand(id: $request->params['id'])
		);

		return DeleteUserResponse::of();
	}

}
