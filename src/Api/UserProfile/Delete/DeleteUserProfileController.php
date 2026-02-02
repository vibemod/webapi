<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Delete;

use App\Api\BetterApiController;
use App\Domain\UserProfile\Command\Delete\DeleteUserProfileCommand;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class DeleteUserProfileController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly CommandBus $commandBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): DeleteUserProfileResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, DeleteUserProfileRequest::class);

		$this->commandBus->handle(
			new DeleteUserProfileCommand(id: $request->params['id'])
		);

		return DeleteUserProfileResponse::of();
	}

}
