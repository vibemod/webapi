<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Query\List;

use App\Domain\Acme\DTO\AcmeRowDto;
use App\Model\Messenger\Result\EntityListResult;

/**
 * @extends EntityListResult<AcmeRowDto>
 */
class ListAcmeResult extends EntityListResult
{

}
