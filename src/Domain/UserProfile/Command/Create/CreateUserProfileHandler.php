<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Command\Create;

use App\Domain\User\Database\User;
use App\Domain\User\Database\UserRepository;
use App\Domain\UserProfile\Database\UserProfile;
use App\Domain\UserProfile\Event\UserProfileCreatedEvent;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateUserProfileHandler
{

	public function __construct(
		private EntityManagerInterface $em,
		private UserRepository $userRepository,
		private EventDispatcherInterface $ed,
	)
	{
	}

	public function __invoke(CreateUserProfileCommand $command): CreateUserProfileResult
	{
		$user = $this->userRepository->findOne($command->userId);

		if ($user === null) {
			throw EntityNotFoundException::notFoundById(User::class, $command->userId);
		}

		$profile = new UserProfile(
			id: Uuid::uuid7()->toString(),
			user: $user,
			firstName: $command->firstName,
			lastName: $command->lastName,
			phone: $command->phone,
			avatar: $command->avatar,
			bio: $command->bio,
			dateOfBirth: $command->dateOfBirth !== null ? new DateTime($command->dateOfBirth) : null,
			gender: $command->gender,
			locale: $command->locale,
		);

		$this->em->persist($profile);
		$this->em->flush();

		$this->ed->dispatch(new UserProfileCreatedEvent($profile));

		return new CreateUserProfileResult(
			userProfile: $profile,
		);
	}

}
