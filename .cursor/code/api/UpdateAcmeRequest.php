<?php

declare(strict_types = 1);

namespace App\Api\Acme\Update;

use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class UpdateAcmeRequest implements SchemaInterface
{

    /**
     * @param array{id: string} $params
     */
    public function __construct(
        public readonly array $params,
        public readonly UpdateAcmeRequestBody $body,
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
            'body' => Expect::structure([
                'name' => Expect::string()->nullable(),
                'description' => Expect::string()->nullable(),
            ])->castTo(UpdateAcmeRequestBody::class),
        ];
    }

}
