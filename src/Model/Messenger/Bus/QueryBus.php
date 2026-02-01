<?php declare(strict_types = 1);

namespace App\Model\Messenger\Bus;

use App\Model\Exception\LogicalException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class QueryBus
{

	private MessageBusInterface $bus;

	public function __construct(MessageBusInterface $bus)
	{
		$this->bus = $bus;
	}

	public function query(object $command): mixed
	{
		return $this->bus->dispatch($command);
	}

	public function resultQuery(object $command): mixed
	{
		$stamp = $this->bus->dispatch($command)->last(HandledStamp::class);

		if ($stamp === null) {
			throw new LogicalException('Missing handled stamp');
		}

		return $stamp->getResult();
	}

	/**
	 * @template T
	 * @param class-string<T> $type
	 * @return T
	 */
	public function typedQuery(object $query, string $type)
	{
		$result = $this->resultQuery($query);

		assert($result instanceof $type, sprintf(
			'given type %s does not match returned type %s',
			$type,
			is_object($result) ? $result::class : gettype($result),
		));

		return $result;
	}

}
