<?php declare(strict_types = 1);

namespace App\Model\Doctrine;

use App\Model\Doctrine\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @template T of object
 */
abstract class AbstractRepository
{

	/**
	 * @param EntityRepository<T> $repository
	 */
	public function __construct(
		protected readonly EntityRepository $repository
	)
	{
	}

	public function createQueryBuilder(): QueryBuilder
	{
		return $this->repository->createQueryBuilder('e');
	}

	/**
	 * @param 0|1|2|4|null $lockMode
	 * @return T
	 */
	public function fetch(mixed $id, int|null $lockMode = null, int|null $lockVersion = null)
	{
		$entity = $this->repository->find($id, $lockMode, $lockVersion);

		if ($entity === null) {
			throw EntityNotFoundException::notFoundById($this->repository->getClassName(), $id);
		}

		return $entity;
	}

	/**
	 * @param array<string, mixed> $criteria
	 * @param array<string, 'asc'|'desc'|'ASC'|'DESC'>|null $orderBy
	 * @return T
	 */
	public function fetchOneBy(array $criteria, ?array $orderBy = null)
	{
		$entity = $this->repository->findOneBy($criteria, $orderBy);

		if ($entity === null) {
			throw EntityNotFoundException::notFoundByCriteria($this->repository->getClassName(), $criteria);
		}

		return $entity;
	}

	/**
	 * @param 0|1|2|4|null $lockMode
	 * @return T|null
	 */
	public function findOne(mixed $id, int|null $lockMode = null, int|null $lockVersion = null)
	{
		return $this->repository->find($id, $lockMode, $lockVersion);
	}

	/**
	 * @param array<string, mixed> $criteria
	 * @param array<string, 'asc'|'desc'|'ASC'|'DESC'>|null $orderBy
	 * @return T|null
	 */
	public function findOneBy(array $criteria, ?array $orderBy = null)
	{
		return $this->repository->findOneBy($criteria, $orderBy);
	}

	/**
	 * @return T[]
	 */
	public function findAll(): array
	{
		return $this->repository->findBy([]);
	}

	/**
	 * @param array<string, mixed> $criteria
	 * @param array<string, 'asc'|'desc'|'ASC'|'DESC'>|null $orderBy
	 * @return T[]
	 */
	public function findBy(array $criteria, ?array $orderBy = null, int|null $limit = null, int|null $offset = null): array
	{
		return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
	}

	/**
	 * @param array<string, mixed> $criteria
	 */
	public function countBy(array $criteria): int
	{
		return $this->repository->count($criteria);
	}

}
