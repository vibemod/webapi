<?php declare(strict_types = 1);

namespace App\Model\DI;

use Contributte\Kernel\Bootconf;
use Contributte\Kernel\Configurator;
use Contributte\Kernel\DI\ParametersExtension;
use Contributte\Kernel\Modules\BaseModule;
use Contributte\Kernel\Utils\Environments;
use Nette\DI\Compiler;

final class ConfigModule extends BaseModule
{

	public const ENV_PRODUCTION = 'production';
	public const ENV_DEVELOPMENT = 'development';

	private ?string $entrypoint;

	private ?string $envMode;

	private ?bool $local;

	private function __construct(
		?string $entrypoint = null,
		?string $envMode = null,
		?bool $local = null
	)
	{
		$this->entrypoint = $entrypoint;
		$this->envMode = $envMode;
		$this->local = $local;
	}

	public static function create(
		?string $entrypoint = null,
		?string $envMode = null,
		bool $local = true,
	): self
	{
		return new static(
			entrypoint: $entrypoint,
			envMode: $envMode,
			local: $local
		);
	}

	public function apply(Configurator $configurator, Bootconf $config): void
	{
		$configurator->addStaticParameters([
			'rootDir' => dirname($config->getRoot()),
			'appDir' => $config->getRoot(),
			'wwwDir' => realpath($config->getRoot() . '/../www'),
			'logDir' => realpath($config->getRoot() . '/../var/log'),
			'tempDir' => realpath($config->getRoot() . '/../var/tmp'),
			'testsDir' => realpath($config->getRoot() . '/../tests'),
			'consoleMode' => PHP_SAPI === 'cli',
			'tracyMode' => null,
		]);

		// parameters
		// @phpstan-ignore-next-line
		$configurator->onCompile[] = static function (Configurator $configurator, Compiler $compiler): void {
			$compiler->addExtension('params', new ParametersExtension());

			$compiler->addConfig([
				'parameters' => [
					'tracyMode' => $configurator->getStaticParameters()['debugMode'] === true && $configurator->getStaticParameters()['consoleMode'] === false,
				],
			]);
		};

		// config/app/[config].neon
		$configs = ['framework.neon', 'parameters.neon', 'services.neon'];
		foreach ($configs as $file) {
			if (file_exists($config->getRoot() . '/../config/app/' . $file)) {
				$configurator->addConfig($config->getRoot() . '/../config/app/' . $file);
			}
		}

		// config/entrypoint/[entrypoint].neon
		if ($this->entrypoint !== null) {
			$configurator->addStaticParameters([
				'entrypointMode' => $this->entrypoint,
			]);

			if (file_exists($config->getRoot() . '/../config/entrypoint/' . $this->entrypoint . '.neon')) {
				$configurator->addConfig($config->getRoot() . '/../config/entrypoint/' . $this->entrypoint . '.neon');
			}
		}

		// config/environment/[env].neon
		$envMode = $this->envMode ?? Environments::getEnvMode();
		if ($envMode !== null) {
			if (file_exists($config->getRoot() . '/../config/environment/' . $envMode . '.neon')) {
				$configurator->addConfig($config->getRoot() . '/../config/environment/' . $envMode . '.neon');
			}
		}

		// config/local.neon
		if ($this->local === true) {
			if (file_exists($config->getRoot() . '/../config/local.neon')) {
				$configurator->addConfig($config->getRoot() . '/../config/local.neon');
			}
		}
	}

}
