<?php declare(strict_types = 1);

namespace App\Api\User\Update;

final class UpdateUserRequestBody
{

	public string | null $email = null;

	public string | null $name = null;

	public int | null $state = null;

}
