<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\DTO;

final readonly class UserProfileRowDto
{

	public function __construct(
		public string $id,
		public string $userId,
		public string $firstName,
		public string $lastName,
		public string | null $phone,
		public string | null $avatar,
		public string | null $bio,
		public string | null $dateOfBirth,
		public string | null $gender,
		public string | null $locale,
		public string $createdAt,
		public string $updatedAt,
	)
	{
	}

	/**
	 * @phpstan-param array{
	 *     id: string,
	 *     user_id: string,
	 *     first_name: string,
	 *     last_name: string,
	 *     phone: string|null,
	 *     avatar: string|null,
	 *     bio: string|null,
	 *     date_of_birth: string|null,
	 *     gender: string|null,
	 *     locale: string|null,
	 *     created_at: string,
	 *     updated_at: string,
	 * } $row
	 */
	public static function fromRow(array $row): self
	{
		return new self(
			id: $row['id'],
			userId: $row['user_id'],
			firstName: $row['first_name'],
			lastName: $row['last_name'],
			phone: $row['phone'],
			avatar: $row['avatar'],
			bio: $row['bio'],
			dateOfBirth: $row['date_of_birth'],
			gender: $row['gender'],
			locale: $row['locale'],
			createdAt: $row['created_at'],
			updatedAt: $row['updated_at'],
		);
	}

}
