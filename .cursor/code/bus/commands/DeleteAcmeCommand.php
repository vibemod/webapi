<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Command\Delete;

use App\Model\Messenger\Command\BaseCommand;

/**
 * @extends BaseCommand<null>
 */
final class DeleteAcmeCommand extends BaseCommand
{

    public function __construct(
        public readonly string $id
    )
    {
    }

}
