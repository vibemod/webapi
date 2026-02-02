<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Query\List;

use App\Domain\UserProfile\DTO\UserProfileRowDto;
use Doctrine\ORM\EntityManagerInterface;
use Nettrine\Extra\Data\QueryHelpers;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ListUserProfileHandler
{

	public function __construct(
		private EntityManagerInterface $em
	)
	{
	}

	public function __invoke(ListUserProfileCommand $command): ListUserProfileResult
	{
		$filter = $command->filter;

		$qb = $this->em->getConnection()
			->createQueryBuilder()
			->select('up.*')
			->from('user_profile', 'up');

		// Filtering
		if ($filter->hasCriterion('userId')) {
			$qb->andWhere('up.user_id = :userId')
				->setParameter('userId', $filter->pullCriterion('userId'));
		}

		// Ordering
		if ($filter->getOrders() === []) {
			// Add default order
			$qb->addOrderBy('up.created_at', 'DESC');
		} else {
			if ($filter->hasOrder('createdAt')) {
				$qb->addOrderBy('up.created_at', (string) $filter->pullOrder('createdAt'));
			}

			if ($filter->hasOrder('updatedAt')) {
				$qb->addOrderBy('up.updated_at', (string) $filter->pullOrder('updatedAt'));
			}
		}

		// General filters & orders & pagination
		QueryHelpers::applyCriteria($qb, $filter, alias: 'up');
		QueryHelpers::applyOrders($qb, $filter, alias: 'up');
		QueryHelpers::applyLimits($qb, $filter);

		// Calculate count
		$count = QueryHelpers::count($this->em, $qb);

		// Fetch results
		$result = $qb->executeQuery()->fetchAllAssociative();

		return new ListUserProfileResult(
			entities: array_map(static fn (array $row) => UserProfileRowDto::fromRow($row), $result), // @phpstan-ignore-line
			count: $count,
			limit: $filter->getLimit(),
			offset: $filter->getOffset(),
			page: $filter->getPage(),
		);
	}

}
