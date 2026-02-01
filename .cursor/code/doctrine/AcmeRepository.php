<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Database;

use App\Model\Doctrine\AbstractRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends AbstractRepository<Acme>
 */
final class AcmeRepository extends AbstractRepository
{

    public function __construct(
        EntityManagerInterface $em
    ) {
        parent::__construct($em->getRepository(Acme::class));
    }

}