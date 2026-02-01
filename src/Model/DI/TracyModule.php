<?php declare(strict_types = 1);

namespace App\Model\DI;

use Contributte\Kernel\Bootconf;
use Contributte\Kernel\Configurator;
use Contributte\Kernel\Modules\BaseModule;
use Contributte\Kernel\Utils\Environments;
use LogicException;
use Tracy\Debugger;

final class TracyModule extends BaseModule
{

	public const MODE_HTML = 'html';
	public const MODE_JSON = 'json';
	public const MODE_TXT = 'txt';

	private ?bool $debugMode;

	private ?string $errorMode;

	private ?string $cookie;

	/**
	 * @phpstan-param self::MODE_* $errorMode
	 */
	private function __construct(
		?bool $debugMode,
		?string $errorMode,
		?string $cookie,
	)
	{
		$this->debugMode = $debugMode;
		$this->errorMode = $errorMode;
		$this->cookie = $cookie;
	}

	/**
	 * @phpstan-param self::MODE_* $errorMode
	 */
	public static function create(
		?bool $debugMode = null,
		?string $errorMode = self::MODE_HTML,
		?string $cookie = null,
	): self
	{
		return new static(
			debugMode: $debugMode,
			errorMode: $errorMode,
			cookie: $cookie
		);
	}

	public function apply(Configurator $configurator, Bootconf $config): void
	{
		// Manual debug mode or automatic detection from ENV
		if ($this->debugMode !== null) {
			$configurator->setDebugMode($this->debugMode);
		} else {
			$configurator->setDebugMode(Environments::isDebug());
		}

		// Debug mode from cookie
		if ($this->cookie !== null && strlen($this->cookie) > 0 && Environments::isDebugCookie($this->cookie)) {
			$configurator->setDebugMode(true);
		}

		// Set logDir from parameters
		/** @var string|null $logDir */
		$logDir = $configurator->getStaticParameters()['logDir'] ?? null;
		if ($logDir === null) {
			throw new LogicException('Missing logDir in parameters');
		}

		$configurator->enableTracy($logDir);

		// tracy/tracy conventions
		$configurator->addConfig([
			'tracy' => [
				'strictMode' => true,
			],
		]);

		if ($this->errorMode !== null) {
			if ($this->errorMode === self::MODE_JSON) {
				Debugger::$errorTemplate = __DIR__ . '/../../resources/500.json';
			} elseif ($this->errorMode === self::MODE_HTML) {
				Debugger::$errorTemplate = __DIR__ . '/../../resources/500.phtml';
			} elseif ($this->errorMode === self::MODE_TXT) {
				Debugger::$errorTemplate = __DIR__ . '/../../resources/500.txt';
			}
		}
	}

}
