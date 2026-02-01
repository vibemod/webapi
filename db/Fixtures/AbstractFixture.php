<?php declare(strict_types = 1);

namespace Database\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture as BaseFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Nette\DI\Container;
use Nettrine\Fixtures\Fixture\ContainerAwareInterface;

abstract class AbstractFixture extends BaseFixture implements ContainerAwareInterface, OrderedFixtureInterface
{

	protected Container | null $container = null;

	public function setContainer(Container $container): void
	{
		$this->container = $container;
	}

	public function getOrder(): int
	{
		return 0;
	}

}
