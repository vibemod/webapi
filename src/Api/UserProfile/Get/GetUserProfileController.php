<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Get;

use App\Api\BetterApiController;
use App\Domain\UserProfile\Query\Get\GetUserProfileCommand;
use App\Domain\UserProfile\Query\Get\GetUserProfileResult;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\QueryBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class GetUserProfileController extends BetterApiController
{

	public function __construct(
		private readonly RequestFactory $requestFactory,
		private readonly QueryBus $queryBus,
		LoggerInterface $logger,
	)
	{
		parent::__construct($logger);
	}

	public function invoke(ServerRequestInterface $serverRequest): GetUserProfileResponse
	{
		$request = $this->requestFactory->createRequest($serverRequest, GetUserProfileRequest::class);

		$result = $this->queryBus->typedQuery(
			new GetUserProfileCommand(id: $request->params['id']),
			GetUserProfileResult::class
		);

		return GetUserProfileResponse::of($result);
	}

}
