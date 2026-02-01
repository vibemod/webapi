<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class AcmeDeletedEvent extends Event
{

    public function __construct(
        public readonly string $id
    )
    {
    }

}
