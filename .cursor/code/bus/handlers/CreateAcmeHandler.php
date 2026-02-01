<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Command\Create;

use App\Domain\Acme\Database\Acme;
use App\Domain\Acme\DTO\AcmeDto;
use App\Domain\Acme\Event\AcmeCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateAcmeHandler
{

    public function __construct(
        private EntityManagerInterface $em,
        private EventDispatcherInterface $ed,
    )
    {
    }

    public function __invoke(CreateAcmeCommand $command): AcmeDto
    {
        $acme = new Acme(
            id: Uuid::uuid7()->toString(),
            name: $command->name,
            description: $command->description,
        );

        $this->em->persist($acme);
        $this->em->flush();

        $this->ed->dispatch(new AcmeCreatedEvent($acme));

        return AcmeDto::fromEntity($acme);
    }

}
