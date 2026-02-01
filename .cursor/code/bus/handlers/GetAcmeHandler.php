<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Query\Get;

use App\Domain\Acme\Database\Acme;
use App\Domain\Acme\Database\AcmeRepository;
use App\Domain\Acme\DTO\AcmeDto;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetAcmeHandler
{

    public function __construct(
        private AcmeRepository $acmeRepository
    )
    {
    }

    public function __invoke(GetAcmeCommand $command): AcmeDto
    {
        $acme = $this->acmeRepository->findOneBy(['id' => $command->id]);

        if ($acme === null) {
            throw EntityNotFoundException::notFoundById(Acme::class, $command->id);
        }

        return AcmeDto::fromEntity($acme);
    }

}
