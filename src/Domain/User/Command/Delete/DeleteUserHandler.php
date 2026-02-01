<?php declare(strict_types = 1);

namespace App\Domain\User\Command\Delete;

use App\Domain\User\Database\User;
use App\Domain\User\Database\UserRepository;
use App\Domain\User\Event\UserDeletedEvent;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteUserHandler
{

	public function __construct(
		private EntityManagerInterface $em,
		private UserRepository $userRepository,
		private EventDispatcherInterface $ed,
	)
	{
	}

	public function __invoke(DeleteUserCommand $command): void
	{
		$user = $this->userRepository->findOne($command->id);

		if ($user === null) {
			throw EntityNotFoundException::notFoundById(User::class, $command->id);
		}

		$this->em->remove($user);
		$this->em->flush();

		$this->ed->dispatch(new UserDeletedEvent($user->getId()));
	}

}
