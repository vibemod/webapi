<?php declare(strict_types = 1);

namespace App\Model\Messenger\Bus;

use App\Model\Exception\LogicalException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class CommandBus
{

	private MessageBusInterface $bus;

	public function __construct(MessageBusInterface $bus)
	{
		$this->bus = $bus;
	}

	public function handle(object $command): Envelope
	{
		return $this->bus->dispatch($command);
	}

	public function resultHandle(object $command): mixed
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
	public function typedHandle(object $command, string $type)
	{
		$result = $this->resultHandle($command);

		assert($result instanceof $type, sprintf(
			'given type %s does not match returned type %s',
			$type,
			is_object($result) ? $result::class : gettype($result),
		));

		return $result;
	}

}
