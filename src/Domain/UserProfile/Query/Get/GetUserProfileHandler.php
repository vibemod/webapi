<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Query\Get;

use App\Domain\UserProfile\Database\UserProfile;
use App\Domain\UserProfile\Database\UserProfileRepository;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetUserProfileHandler
{

	public function __construct(
		private UserProfileRepository $userProfileRepository
	)
	{
	}

	public function __invoke(GetUserProfileCommand $command): GetUserProfileResult
	{
		$profile = $this->userProfileRepository->findOne($command->id);

		if ($profile === null) {
			throw EntityNotFoundException::notFoundById(UserProfile::class, $command->id);
		}

		return new GetUserProfileResult(
			userProfile: $profile,
		);
	}

}
