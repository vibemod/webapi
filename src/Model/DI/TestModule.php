<?php declare(strict_types = 1);

namespace App\Model\DI;

use Contributte\Kernel\Bootconf;
use Contributte\Kernel\Configurator;
use Contributte\Kernel\Modules\BaseModule;

final class TestModule extends BaseModule
{

	private bool $random;

	private function __construct(
		bool $random = true,
	)
	{
		$this->random = $random;
	}

	public static function create(
		bool $random = true,
	): self
	{
		return new static(
			random: $random
		);
	}

	public function apply(Configurator $configurator, Bootconf $config): void
	{
		$configurator->addStaticParameters([
			'testMode' => true,
			'testRandom' => $this->random ? sha1(random_bytes(16)) : '123456789',
		]);
	}

}
