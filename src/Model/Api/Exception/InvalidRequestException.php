<?php declare(strict_types = 1);

namespace App\Model\Api\Exception;

use App\Model\Exception\RuntimeException;
use Nette\Schema\ValidationException;
use Throwable;

class InvalidRequestException extends RuntimeException
{

	public const TYPE_BODY = 1;
	public const TYPE_QUERY = 2;
	public const TYPE_PARAMETERS = 3;

	/** @var array<string, string> */
	private array $validations = [];

	private int $type;

	private function __construct(string $message, int $type, Throwable $previous)
	{
		parent::__construct($message, 0, $previous);

		$this->type = $type;
	}

	public static function invalidQuery(ValidationException $e): self
	{
		$self = new self($e->getMessage(), self::TYPE_QUERY, $e);
		$self->validations = $e->getMessages();

		return $self;
	}

	public static function invalidBody(ValidationException $e): self
	{
		$self = new self($e->getMessage(), self::TYPE_BODY, $e);
		$self->validations = $e->getMessages();

		return $self;
	}

	public static function invalidParameters(ValidationException $e): self
	{
		$self = new self($e->getMessage(), self::TYPE_PARAMETERS, $e);
		$self->validations = $e->getMessages();

		return $self;
	}

	/**
	 * @return array<string, string>
	 */
	public function getValidations(): array
	{
		return $this->validations;
	}

	public function getType(): int
	{
		return $this->type;
	}

}
