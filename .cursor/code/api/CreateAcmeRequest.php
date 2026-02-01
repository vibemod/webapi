<?php

declare(strict_types = 1);

namespace App\Api\Acme\Create;

use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class CreateAcmeRequest implements SchemaInterface
{

    public function __construct(
        public readonly CreateAcmeRequestBody $body,
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public static function schema(): array
    {
        return [
            'body' => Expect::structure([
                'name' => Expect::string()->required(),
                'description' => Expect::string()->required(),
            ])->castTo(CreateAcmeRequestBody::class),
        ];
    }

}
