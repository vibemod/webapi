<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Command\Update;

use App\Domain\Acme\DTO\AcmeDto;
use App\Model\Messenger\Command\BaseCommand;

/**
 * @extends BaseCommand<AcmeDto>
 */
final class UpdateAcmeCommand extends BaseCommand
{

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $description,
    )
    {
    }

}
