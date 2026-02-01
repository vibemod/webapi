<?php declare(strict_types = 1);

namespace App\Domain\User\Database;

use App\Model\Doctrine\AbstractRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends AbstractRepository<User>
 */
final class UserRepository extends AbstractRepository
{

	public function __construct(
		EntityManagerInterface $em
	)
	{
		parent::__construct($em->getRepository(User::class));
	}

}
