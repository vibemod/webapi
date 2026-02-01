<?php

declare(strict_types = 1);

namespace App\Api\Acme\Update;

use App\Api\BetterApiController;
use App\Domain\Acme\Command\Update\UpdateAcmeCommand;
use App\Domain\Acme\DTO\AcmeDto;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class UpdateAcmeController extends BetterApiController
{

    public function __construct(
        private readonly RequestFactory $requestFactory,
        private readonly CommandBus $commandBus,
        LoggerInterface $logger,
    )
    {
        parent::__construct($logger);
    }

    public function invoke(ServerRequestInterface $serverRequest): UpdateAcmeResponse
    {
        $request = $this->requestFactory->createRequest($serverRequest, UpdateAcmeRequest::class);

        $acme = $this->commandBus->typedHandle(
            new UpdateAcmeCommand(
                id: $request->params['id'],
                name: $request->body->name,
                description: $request->body->description,
            ),
            AcmeDto::class
        );

        return UpdateAcmeResponse::of($acme);
    }

}
