<?php declare(strict_types = 1);

namespace App\Domain\User\Command\Create;

use App\Domain\User\Database\User;
use App\Domain\User\Event\UserCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateUserHandler
{

	public function __construct(
		private EntityManagerInterface $em,
		private EventDispatcherInterface $ed,
	)
	{
	}

	public function __invoke(CreateUserCommand $command): CreateUserResult
	{
		$user = new User(
			id: Uuid::uuid7()->toString(),
			email: $command->email,
			name: $command->name,
			state: $command->state,
		);

		$this->em->persist($user);
		$this->em->flush();

		$this->ed->dispatch(new UserCreatedEvent($user));

		return new CreateUserResult(
			user: $user,
		);
	}

}
