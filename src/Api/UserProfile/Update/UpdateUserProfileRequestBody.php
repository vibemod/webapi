<?php declare(strict_types = 1);

namespace App\Api\UserProfile\Update;

final class UpdateUserProfileRequestBody
{

	public string | null $firstName = null;

	public string | null $lastName = null;

	public string | null $phone = null;

	public string | null $avatar = null;

	public string | null $bio = null;

	public string | null $dateOfBirth = null;

	public string | null $gender = null;

	public string | null $locale = null;

}
