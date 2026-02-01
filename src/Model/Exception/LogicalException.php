<?php declare(strict_types = 1);

namespace App\Model\Exception;

use LogicException;

class LogicalException extends LogicException
{

	/** @var array<string, mixed> */
	public array $context = [];

	/**
	 * @param array<string, mixed> $context
	 */
	public static function of(string $message, array $context): self
	{
		$formattedMessage = preg_replace_callback(
			'/{([^}]+)}/',
			static function ($matches) use ($context) {
				$key = $matches[1];

				return strval($context[$key] ?? '{' . $key . '}'); // @phpstan-ignore-line
			},
			$message
		);

		$self = new self($formattedMessage ?? $message);
		$self->context = $context;

		return $self;
	}

}
