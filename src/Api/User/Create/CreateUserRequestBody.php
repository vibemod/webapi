<?php declare(strict_types = 1);

namespace App\Api\User\Create;

final class CreateUserRequestBody
{

	public string $email;

	public string $name;

	public int $state;

}
