<?php

declare(strict_types = 1);

namespace App\Api\Acme\Delete;

use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class DeleteAcmeRequest implements SchemaInterface
{

    /**
     * @param array{id: string} $params
     */
    public function __construct(
        public readonly array $params,
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public static function schema(): array
    {
        return [
            'params' => Expect::structure([
                'id' => Expect::string()->required(),
            ])->castTo('array'),
        ];
    }

}
