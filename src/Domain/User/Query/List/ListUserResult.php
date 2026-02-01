<?php declare(strict_types = 1);

namespace App\Domain\User\Query\List;

use App\Domain\User\DTO\UserRowDto;
use App\Model\Messenger\Result\EntityListResult;

/**
 * @extends EntityListResult<UserRowDto>
 */
final class ListUserResult extends EntityListResult
{

}
