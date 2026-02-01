<?php declare(strict_types = 1);

namespace Tests\App;

use App\Bootstrap;
use Contributte\FrameX\Application as WebApplication;
use Contributte\Phpunit\AbstractTestCase;
use Nette\DI\Container;
use Nette\Utils\FileSystem;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use Symfony\Component\Console\Application as ConsoleApplication;
use Tests\Toolkit\Tests;

final class EntrypointTest extends AbstractTestCase
{

	public function setUp(): void
	{
		parent::setUp();

		if (!file_exists(Tests::CONFIG_DIR . '/local.neon')) {
			FileSystem::copy(
				Tests::CONFIG_DIR . '/local.neon.example',
				Tests::CONFIG_DIR . '/local.neon'
			);
		}
	}

	#[RunInSeparateProcess]
	public function testWeb(): void
	{
		$container = Bootstrap::bootForWeb()->createContainer();
		$container->getByType(WebApplication::class);

		$this->assertInstanceOf(Container::class, $container);
	}

	#[RunInSeparateProcess]
	public function testCli(): void
	{
		$container = Bootstrap::bootForCli()->createContainer();
		$container->getByType(ConsoleApplication::class);

		$this->assertInstanceOf(Container::class, $container);
	}

	#[RunInSeparateProcess]
	public function testTest(): void
	{
		$container = Bootstrap::bootForTests()->createContainer();
		$container->getByType(Container::class);

		$this->assertInstanceOf(Container::class, $container);
	}

}
