<?php declare(strict_types = 1);

namespace App\Api\User\List;

use App\Api\BetterApiController;
use App\Domain\User\Query\List\ListUserCommand;
use App\Domain\User\Query\List\ListUserResult;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\QueryBus;
use Nettrine\Extra\Data\QueryFilter;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class ListUserController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly QueryBus $queryBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): ListUserResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, ListUserRequest::class);

		$result = $this->queryBus->typedQuery(
			new ListUserCommand(
				filter: QueryFilter::from($request->query->toArray())
			),
			ListUserResult::class
		);

		return ListUserResponse::of($result);
	}

}
