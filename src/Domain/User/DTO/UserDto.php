<?php declare(strict_types = 1);

namespace App\Domain\User\DTO;

use App\Domain\User\Database\User;

final readonly class UserDto
{

	public function __construct(
		public string $id,
		public string $email,
		public string $name,
		public int $state,
		public string $createdAt,
		public string $updatedAt,
	)
	{
	}

	public static function fromEntity(User $user): self
	{
		return new self(
			id: $user->getId(),
			email: $user->email,
			name: $user->name,
			state: $user->state,
			createdAt: $user->createdAt->format('Y-m-d\TH:i:s.u\Z'),
			updatedAt: $user->updatedAt->format('Y-m-d\TH:i:s.u\Z'),
		);
	}

}
