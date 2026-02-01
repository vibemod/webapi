<?php declare(strict_types = 1);

namespace Tests\E2E;

use App\Bootstrap;
use Contributte\FrameX\Application as WebApplication;
use Contributte\Phpunit\AbstractTestCase;
use Contributte\Tester\Utils\Liberator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use FrameworkX\App;
use Nette\DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class ApiTestCase extends AbstractTestCase
{

	protected App $app;

	protected Container $container;

	protected EntityManagerInterface $em;

	public function setUp(): void
	{
		parent::setUp();

		// Create container
		$this->container = Bootstrap::bootForTests()->createContainer();

		// Services
		$this->em = $this->container->getByType(EntityManagerInterface::class);

		/** @var WebApplication $webApp */
		$webApp = $this->container->getByType(WebApplication::class);
		$this->app = Liberator::of($webApp)->app;

		// Create schema
		$metadata = $this->em->getMetadataFactory()->getAllMetadata();
		$tool = new SchemaTool($this->em);
		$tool->createSchema($metadata);

		// Populate database
		$this->load($this->em);
	}

	protected function dispatch(ServerRequestInterface $request): ResponseInterface
	{
		ob_start();
		$response = ($this->app)($request);
		ob_get_clean();

		return $response;
	}

	protected function load(EntityManagerInterface $em): void
	{
		// No-op
	}

}
