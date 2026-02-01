<?php declare(strict_types = 1);

namespace App\Domain\User\Command\Update;

use App\Domain\User\Database\User;
use App\Domain\User\Database\UserRepository;
use App\Domain\User\Event\UserUpdatedEvent;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateUserHandler
{

	public function __construct(
		private EntityManagerInterface $em,
		private UserRepository $userRepository,
		private EventDispatcherInterface $ed,
	)
	{
	}

	public function __invoke(UpdateUserCommand $command): UpdateUserResult
	{
		$user = $this->userRepository->findOne($command->id);

		if ($user === null) {
			throw EntityNotFoundException::notFoundById(User::class, $command->id);
		}

		if ($command->email !== null) {
			$user->email = $command->email;
		}

		if ($command->name !== null) {
			$user->name = $command->name;
		}

		if ($command->state !== null) {
			$user->state = $command->state;
		}

		$this->em->persist($user);
		$this->em->flush();

		$this->ed->dispatch(new UserUpdatedEvent($user));

		return new UpdateUserResult(
			user: $user,
		);
	}

}
