<?php declare(strict_types = 1);

namespace App\Domain\User\Query\List;

use App\Domain\User\DTO\UserRowDto;
use Doctrine\ORM\EntityManagerInterface;
use Nettrine\Extra\Data\QueryHelpers;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ListUserHandler
{

	public function __construct(
		private EntityManagerInterface $em
	)
	{
	}

	public function __invoke(ListUserCommand $command): ListUserResult
	{
		$filter = $command->filter;

		$qb = $this->em->getConnection()
			->createQueryBuilder()
			->select('u.*')
			->from('user', 'u');

		// Filtering
		if ($filter->hasCriterion('state')) {
			$qb->andWhere('u.state = :state')
				->setParameter('state', $filter->pullCriterion('state'));
		}

		// Ordering
		if ($filter->getOrders() === []) {
			// Add default order
			$qb->addOrderBy('u.created_at', 'DESC');
		} else {
			if ($filter->hasOrder('createdAt')) {
				$qb->addOrderBy('u.created_at', (string) $filter->pullOrder('createdAt'));
			}

			if ($filter->hasOrder('updatedAt')) {
				$qb->addOrderBy('u.updated_at', (string) $filter->pullOrder('updatedAt'));
			}
		}

		// General filters & orders & pagination
		QueryHelpers::applyCriteria($qb, $filter, alias: 'u');
		QueryHelpers::applyOrders($qb, $filter, alias: 'u');
		QueryHelpers::applyLimits($qb, $filter);

		// Calculate count
		$count = QueryHelpers::count($this->em, $qb);

		// Fetch results
		$result = $qb->executeQuery()->fetchAllAssociative();

		return new ListUserResult(
			entities: array_map(static fn (array $row) => UserRowDto::fromRow($row), $result), // @phpstan-ignore-line
			count: $count,
			limit: $filter->getLimit(),
			offset: $filter->getOffset(),
			page: $filter->getPage(),
		);
	}

}
