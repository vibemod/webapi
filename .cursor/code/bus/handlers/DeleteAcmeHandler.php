<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Command\Delete;

use App\Domain\Acme\Database\Acme;
use App\Domain\Acme\Event\AcmeDeletedEvent;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteAcmeHandler
{

    public function __construct(
        private EntityManagerInterface $em,
        private EventDispatcherInterface $ed,
    )
    {
    }

    public function __invoke(DeleteAcmeCommand $command): void
    {
        $acme = $this->em->getRepository(Acme::class)->findOneBy(['id' => $command->id]);

        if ($acme === null) {
            throw EntityNotFoundException::notFoundById(Acme::class, $command->id);
        }

        $this->em->remove($acme);
        $this->em->flush();

        $this->ed->dispatch(new AcmeDeletedEvent($command->id));
    }

}
