<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Database;

use App\Model\Doctrine\AbstractRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends AbstractRepository<UserProfile>
 */
final class UserProfileRepository extends AbstractRepository
{

	public function __construct(
		EntityManagerInterface $em
	)
	{
		parent::__construct($em->getRepository(UserProfile::class));
	}

}
