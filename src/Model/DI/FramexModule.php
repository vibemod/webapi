<?php declare(strict_types = 1);

namespace App\Model\DI;

use Contributte\Kernel\Bootconf;
use Contributte\Kernel\Configurator;
use Contributte\Kernel\Modules\BaseModule;

final class FramexModule extends BaseModule
{

	private const DISABLE_EXTENSIONS = [
		'application',
		'cache',
		'database',
		'forms',
		'http',
		'latte',
		'mail',
		'routing',
		'search',
		'security',
		'session',
	];

	private ?bool $unset = null;

	private function __construct(
		?bool $unset = null,
	)
	{
		$this->unset = $unset;
	}

	public static function create(
		bool $unset = true,
	): self
	{
		return new static(
			unset: $unset
		);
	}

	public function apply(Configurator $configurator, Bootconf $config): void
	{
		// Disable default Nette extensions
		if ($this->unset === true) {
			foreach (self::DISABLE_EXTENSIONS as $extension) {
				unset($configurator->defaultExtensions[$extension]);
			}
		}

		// Override nette/http in configurator
		$configurator->addStaticParameters([
			'baseUrl' => null,
		]);
	}

}
