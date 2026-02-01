<?php declare(strict_types = 1);

namespace App\Domain\User\Query\Get;

use App\Domain\User\Database\User;
use App\Domain\User\Database\UserRepository;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetUserHandler
{

	public function __construct(
		private UserRepository $userRepository
	)
	{
	}

	public function __invoke(GetUserCommand $command): GetUserResult
	{
		$user = $this->userRepository->findOne($command->id);

		if ($user === null) {
			throw EntityNotFoundException::notFoundById(User::class, $command->id);
		}

		return new GetUserResult(
			user: $user,
		);
	}

}
