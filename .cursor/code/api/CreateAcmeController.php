<?php

declare(strict_types = 1);

namespace App\Api\Acme\Create;

use App\Api\BetterApiController;
use App\Domain\Acme\Command\Create\CreateAcmeCommand;
use App\Domain\Acme\DTO\AcmeDto;
use App\Model\Api\RequestFactory;
use App\Model\Messenger\Bus\CommandBus;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class CreateAcmeController extends BetterApiController
{

    public function __construct(
        private readonly RequestFactory $requestFactory,
        private readonly CommandBus $commandBus,
        LoggerInterface $logger,
    )
    {
        parent::__construct($logger);
    }

    public function invoke(ServerRequestInterface $serverRequest): CreateAcmeResponse
    {
        $request = $this->requestFactory->createRequest($serverRequest, CreateAcmeRequest::class);

        $acme = $this->commandBus->typedHandle(
            new CreateAcmeCommand(
                name: $request->body->name,
                description: $request->body->description,
            ),
            AcmeDto::class
        );

        return CreateAcmeResponse::of($acme);
    }

}
