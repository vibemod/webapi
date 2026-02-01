<?php

declare(strict_types = 1);

namespace App\Domain\Acme\Event;

use App\Domain\Acme\Database\Acme;
use Symfony\Contracts\EventDispatcher\Event;

final class AcmeCreatedEvent extends Event
{

    public function __construct(
        public readonly Acme $acme
    )
    {
    }

}
