<?php

declare(strict_types = 1);

namespace App\Api\Acme\Delete;

use App\Api\BetterApiController;
use App\Domain\Acme\Command\Delete\DeleteAcmeCommand;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class DeleteAcmeController extends BetterApiController
{

    public function __construct(
        private readonly RequestFactory $requestFactory,
        private readonly CommandBus $commandBus,
        LoggerInterface $logger,
    )
    {
        parent::__construct($logger);
    }

    public function invoke(ServerRequestInterface $serverRequest): DeleteAcmeResponse
    {
        $request = $this->requestFactory->createRequest($serverRequest, DeleteAcmeRequest::class);

        $this->commandBus->handle(
            new DeleteAcmeCommand(
                id: $request->params['id'],
            )
        );

        return DeleteAcmeResponse::of();
    }

}
