<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Command\Update;

use App\Domain\UserProfile\Database\UserProfile;
use App\Domain\UserProfile\Database\UserProfileRepository;
use App\Domain\UserProfile\Event\UserProfileUpdatedEvent;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateUserProfileHandler
{

	public function __construct(
		private EntityManagerInterface $em,
		private UserProfileRepository $userProfileRepository,
		private EventDispatcherInterface $ed,
	)
	{
	}

	public function __invoke(UpdateUserProfileCommand $command): UpdateUserProfileResult
	{
		$profile = $this->userProfileRepository->findOne($command->id);

		if ($profile === null) {
			throw EntityNotFoundException::notFoundById(UserProfile::class, $command->id);
		}

		if ($command->firstName !== null) {
			$profile->firstName = $command->firstName;
		}

		if ($command->lastName !== null) {
			$profile->lastName = $command->lastName;
		}

		if ($command->phone !== null) {
			$profile->phone = $command->phone;
		}

		if ($command->avatar !== null) {
			$profile->avatar = $command->avatar;
		}

		if ($command->bio !== null) {
			$profile->bio = $command->bio;
		}

		if ($command->dateOfBirth !== null) {
			$profile->dateOfBirth = new DateTime($command->dateOfBirth);
		}

		if ($command->gender !== null) {
			$profile->gender = $command->gender;
		}

		if ($command->locale !== null) {
			$profile->locale = $command->locale;
		}

		$this->em->persist($profile);
		$this->em->flush();

		$this->ed->dispatch(new UserProfileUpdatedEvent($profile));

		return new UpdateUserProfileResult(
			userProfile: $profile,
		);
	}

}
