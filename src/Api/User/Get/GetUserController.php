<?php declare(strict_types = 1);

namespace App\Api\User\Get;

use App\Api\BetterApiController;
use App\Domain\User\Query\Get\GetUserCommand;
use App\Domain\User\Query\Get\GetUserResult;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\QueryBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class GetUserController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly QueryBus $queryBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): GetUserResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, GetUserRequest::class);

		$result = $this->queryBus->typedQuery(
			new GetUserCommand(id: $request->params['id']),
			GetUserResult::class
		);

		return GetUserResponse::of($result);
	}

}
