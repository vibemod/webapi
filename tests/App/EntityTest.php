<?php declare(strict_types = 1);

namespace Tests\App;

use App\Bootstrap;
use Contributte\Phpunit\AbstractTestCase;
use Contributte\Tester\Utils\ClassFinder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Tools\SchemaValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use ReflectionClass;
use Tests\Toolkit\Tests;

final class EntityTest extends AbstractTestCase
{

	private EntityManagerInterface | null $em = null;

	/**
	 * @return iterable<string>
	 */
	public static function provideEntities(): iterable
	{
		$classes = ClassFinder::create()
			->addFolder(Tests::APP_DIR)
			->find();

		foreach ($classes as $rc) {
			$attrs = $rc->getAttributes(Entity::class);

			if ($attrs === []) {
				continue;
			}

			yield $rc->getFileName() => [$rc->getName()];
		}
	}

	public function setUp(): void
	{
		parent::setUp();

		if ($this->em === null) {
			$container = Bootstrap::bootForTests()->createContainer();
			$this->em = $container->getByType(EntityManagerInterface::class);
		}
	}

	public function testMapping(): void
	{
		$validator = new SchemaValidator($this->em);
		$validations = $validator->validateMapping();

		foreach ($validations as $fails) {
			foreach ($fails as $fail) {
				$this->fail($fail);
			}
		}

		$this->assertCount(0, $validations);
	}

	#[DataProvider('provideEntities')]
	#[RunInSeparateProcess]
	public function testEntity(string $class): void
	{
		$rc = new ReflectionClass($class);

		$this->assertFalse($rc->isFinal(), sprintf('Class %s must not be final.', $rc->getShortName()));
		$this->assertFalse($rc->isAbstract(), sprintf('Class %s must not be abstract.', $rc->getShortName()));
		$this->assertFalse($rc->isReadOnly(), sprintf('Class %s must not be read-only.', $rc->getShortName()));
	}

}
