<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Command\Delete;

use App\Domain\UserProfile\Database\UserProfile;
use App\Domain\UserProfile\Database\UserProfileRepository;
use App\Domain\UserProfile\Event\UserProfileDeletedEvent;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteUserProfileHandler
{

	public function __construct(
		private EntityManagerInterface $em,
		private UserProfileRepository $userProfileRepository,
		private EventDispatcherInterface $ed,
	)
	{
	}

	public function __invoke(DeleteUserProfileCommand $command): void
	{
		$profile = $this->userProfileRepository->findOne($command->id);

		if ($profile === null) {
			throw EntityNotFoundException::notFoundById(UserProfile::class, $command->id);
		}

		$this->em->remove($profile);
		$this->em->flush();

		$this->ed->dispatch(new UserProfileDeletedEvent($profile->getId()));
	}

}
