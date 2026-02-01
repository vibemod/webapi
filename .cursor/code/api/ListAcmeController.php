<?php

declare(strict_types = 1);

namespace App\Api\Acme\List;

use App\Api\BetterApiController;
use App\Domain\Acme\Query\List\ListAcmeCommand;
use App\Domain\Acme\Query\List\ListAcmeResult;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\QueryBus;
use Nettrine\Extra\Data\QueryFilter;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class ListAcmeController extends BetterApiController
{

    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly RequestFactory $requestFactory,
        LoggerInterface $logger,
    )
    {
        parent::__construct($logger);
    }

    public function invoke(ServerRequestInterface $serverRequest): ListAcmeResponse
    {
        $request = $this->requestFactory->createRequest($serverRequest, ListAcmeRequest::class);

        $acmes = $this->queryBus->typedQuery(
            new ListAcmeCommand(
                filter: QueryFilter::from($request->query->toArray())
            ),
            ListAcmeResult::class
        );

        return ListAcmeResponse::of($acmes);
    }

}
