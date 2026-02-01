<?php

declare(strict_types = 1);

namespace App\Api\Acme\Get;

use App\Api\BetterApiController;
use App\Domain\Acme\DTO\AcmeDto;
use App\Domain\Acme\Query\Get\GetAcmeCommand;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\QueryBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class GetAcmeController extends BetterApiController
{

    public function __construct(
        private readonly RequestFactory $requestFactory,
        private readonly QueryBus $queryBus,
        LoggerInterface $logger,
    )
    {
        parent::__construct($logger);
    }

    public function invoke(ServerRequestInterface $serverRequest): GetAcmeResponse
    {
        $request = $this->requestFactory->createRequest($serverRequest, GetAcmeRequest::class);

        $acme = $this->queryBus->typedQuery(
            new GetAcmeCommand(
                id: $request->params['id'],
            ),
            AcmeDto::class
        );

        return GetAcmeResponse::of($acme);
    }

}
