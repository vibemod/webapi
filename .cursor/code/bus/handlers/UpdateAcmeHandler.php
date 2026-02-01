<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Command\Update;

use App\Domain\Acme\Database\Acme;
use App\Domain\Acme\DTO\AcmeDto;
use App\Domain\Acme\Event\AcmeUpdatedEvent;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateAcmeHandler
{

    public function __construct(
        private EntityManagerInterface $em,
        private EventDispatcherInterface $ed,
    )
    {
    }

    public function __invoke(UpdateAcmeCommand $command): AcmeDto
    {
        $acme = $this->em->getRepository(Acme::class)->findOneBy(['id' => $command->id]);

        if ($acme === null) {
            throw EntityNotFoundException::notFoundById(Acme::class, $command->id);
        }

        if ($command->name !== null) {
            $acme->name = $command->name;
        }

        if ($command->description !== null) {
            $acme->description = $command->description;
        }

        $this->em->persist($acme);
        $this->em->flush();

        $this->ed->dispatch(new AcmeUpdatedEvent($acme));

        return AcmeDto::fromEntity($acme);
    }

}
