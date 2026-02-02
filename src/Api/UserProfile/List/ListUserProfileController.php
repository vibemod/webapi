<?php declare(strict_types = 1);

namespace App\Api\UserProfile\List;

use App\Api\BetterApiController;
use App\Domain\UserProfile\Query\List\ListUserProfileCommand;
use App\Domain\UserProfile\Query\List\ListUserProfileResult;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\QueryBus;
use Nettrine\Extra\Data\QueryFilter;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class ListUserProfileController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly QueryBus $queryBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): ListUserProfileResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, ListUserProfileRequest::class);

		$result = $this->queryBus->typedQuery(
			new ListUserProfileCommand(
				filter: QueryFilter::from($request->query->toArray())
			),
			ListUserProfileResult::class
		);

		return ListUserProfileResponse::of($result);
	}

}
