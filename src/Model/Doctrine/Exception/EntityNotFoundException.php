<?php declare(strict_types = 1);

namespace App\Model\Doctrine\Exception;

use App\Model\Exception\RuntimeException;
use Nette\Utils\Arrays;
use Stringable;
use Throwable;

class EntityNotFoundException extends RuntimeException
{

	/** @var array<string, mixed>|null */
	public ?array $criteria = null;

	public function __construct(string $message, int $code, ?Throwable $previous)
	{
		parent::__construct($message, $code, $previous);
	}

	public static function notFoundById(string $class, mixed $id): self
	{
		$e = new self(sprintf('Entity "%s" not found by id "%s"', Arrays::last(explode('\\', strtolower($class))), self::value($id)), 0, null);
		$e->criteria = ['id' => $id];

		return $e;
	}

	/**
	 * @param array<string, mixed> $criteria
	 */
	public static function notFoundByCriteria(string $class, array $criteria): self
	{
		$e = new self(sprintf('Entity "%s" not found by criteria', Arrays::last(explode('\\', strtolower($class)))), 0, null);
		$e->criteria = $criteria;

		return $e;
	}

	private static function value(mixed $input): string
	{
		if (is_scalar($input)) {
			return (string) $input;
		}

		if ($input instanceof Stringable) {
			return (string) $input;
		}

		if (is_object($input)) {
			return $input::class . '(' . spl_object_id($input) . ')';
		}

		return gettype($input);
	}

}
