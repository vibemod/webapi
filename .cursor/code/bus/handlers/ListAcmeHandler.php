<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Query\List;

use App\Domain\Acme\DTO\AcmeRowDto;
use Doctrine\ORM\EntityManagerInterface;
use Nettrine\Extra\Data\QueryHelpers;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ListAcmeHandler
{

    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function __invoke(ListAcmeCommand $command): ListAcmeResult
    {
        $filter = $command->filter;

        $qb = $this->em->getConnection()
            ->createQueryBuilder()
            ->select('a.*')
            ->from('acme', 'a');

        // Filtering
        if ($filter->hasCriterion('project')) {
            $qb->andWhere('a.project = :project')->setParameter('project', $filter->pullCriterion('project'));
        }

        // Ordering
        if ($filter->getOrders() === []) {
            // Add default order.
            $qb->addOrderBy('a.created_at', 'DESC');
        } else {
            // Non-default order.
            if ($filter->hasOrder('createdAt')) {
                $qb->addOrderBy('a.created_at', (string) $filter->pullOrder('createdAt'));
            }

            if ($filter->hasOrder('updatedAt')) {
                $qb->addOrderBy('a.updated_at', (string) $filter->pullOrder('updatedAt'));
            }
        }

        // General filters & orders & pagination
        QueryHelpers::applyCriteria($qb, $filter, alias: 'a');
        QueryHelpers::applyOrders($qb, $filter, alias: 'a');
        QueryHelpers::applyLimits($qb, $filter);

        // Calculate count
        $count = QueryHelpers::count($this->em, $qb);

        // Fetch results
        $result = $qb->executeQuery()->fetchAllAssociative();

        return new ListAcmeResult(
            entities: array_map(static fn (array $row) => AcmeRowDto::fromRow($row), $result), // @phpstan-ignore-line
            count: $count,
            limit: $filter->getLimit(),
            offset: $filter->getOffset(),
            page: $filter->getPage(),
        );
    }

}
