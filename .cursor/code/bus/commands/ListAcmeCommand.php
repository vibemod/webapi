<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Query\List;

use App\Model\Messenger\Command\BaseCommand;
use Nettrine\Extra\Data\QueryFilter;

/**
 * @extends BaseCommand<ListAcmeResult>
 */
class ListAcmeCommand extends BaseCommand
{

    public function __construct(
        public readonly QueryFilter $filter
    )
    {
    }

}
