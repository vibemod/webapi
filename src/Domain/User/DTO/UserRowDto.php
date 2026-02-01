<?php declare(strict_types = 1);

namespace App\Domain\User\DTO;

final readonly class UserRowDto
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

	/**
	 * @phpstan-param array{
	 *     id: string,
	 *     email: string,
	 *     name: string,
	 *     state: int,
	 *     created_at: string,
	 *     updated_at: string,
	 * } $row
	 */
	public static function fromRow(array $row): self
	{
		return new self(
			id: $row['id'],
			email: $row['email'],
			name: $row['name'],
			state: $row['state'],
			createdAt: $row['created_at'],
			updatedAt: $row['updated_at'],
		);
	}

}
