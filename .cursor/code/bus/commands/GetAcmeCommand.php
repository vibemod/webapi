<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Query\Get;

use App\Domain\Acme\DTO\AcmeDto;
use App\Model\Messenger\Command\BaseCommand;

/**
 * @extends BaseCommand<AcmeDto>
 */
final class GetAcmeCommand extends BaseCommand
{

    public function __construct(
        public readonly string $id
    )
    {
    }

}
