<?php declare(strict_types = 1);

namespace App\Model\Messenger\Result;

/**
 * @template T of object
 */
abstract class EntityListResult
{

	/**
	 * @param iterable<T> $entities
	 */
	public function __construct(
		public readonly iterable $entities,
		public readonly ?int $count,
		public readonly ?int $limit,
		public readonly ?int $offset,
		public readonly ?int $page,
	)
	{
	}

}
