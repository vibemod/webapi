<?php declare(strict_types = 1);

namespace App;

use App\Model\DI\ConfigModule;
use App\Model\DI\FramexModule;
use App\Model\DI\TestModule;
use App\Model\DI\TracyModule;
use Contributte\FrameX\Application as WebApplication;
use Contributte\Kernel\Bootloader;
use Contributte\Kernel\Kernel;
use Contributte\Kernel\Modules\EnvModule;
use Symfony\Component\Console\Application as SymfonyApplication;

final class Bootstrap
{

	public static function bootForWeb(): Kernel
	{
		return Bootloader::of(__DIR__)
			->use(EnvModule::create())
			->use(ConfigModule::create(entrypoint: 'web'))
			->use(TracyModule::create())
			->use(FramexModule::create())
			->boot();
	}

	public static function bootForCli(): Kernel
	{
		return Bootloader::of(__DIR__)
			->use(EnvModule::create())
			->use(ConfigModule::create(entrypoint: 'cli'))
			->use(TracyModule::create())
			->use(FramexModule::create())
			->boot();
	}

	public static function bootForTests(): Kernel
	{
		return Bootloader::of(__DIR__)
			->use(EnvModule::create())
			->use(ConfigModule::create(entrypoint: 'test', local: false))
			->use(FramexModule::create())
			->use(TestModule::create())
			->boot();
	}

	public static function runForCli(): void
	{
		self::bootForCli()
			->createContainer()
			->getByType(SymfonyApplication::class)
			->run();
	}

	public static function runForWeb(): void
	{
		self::bootForWeb()
			->createContainer()
			->getByType(WebApplication::class)
			->run();
	}

}
