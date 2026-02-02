<?php declare(strict_types = 1);

namespace App\Domain\UserProfile\Query\List;

use App\Domain\UserProfile\DTO\UserProfileRowDto;
use App\Model\Messenger\Result\EntityListResult;

/**
 * @extends EntityListResult<UserProfileRowDto>
 */
final class ListUserProfileResult extends EntityListResult
{

}
