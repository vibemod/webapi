<?php

declare(strict_types = 1);

namespace App\Api\Acme\List;

use App\Model\Api\RequestFilter;
use App\Model\Api\SchemaInterface;
use Nette\Schema\Expect;

final class ListAcmeRequest implements SchemaInterface
{

    public function __construct(
        public readonly RequestFilter $query,
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public static function schema(): array
    {
        return [
            'query' => RequestFilter::extend([
                'o' => Expect::structure([
                    'name' => Expect::string()->required(false),
                    'createdAt' => Expect::string()->required(false),
                ])->required(false)->castTo('array'),
                'q' => Expect::structure([
                    'name' => Expect::string()->required(false),
                ])->required(false)->castTo('array'),
            ])->castTo(RequestFilter::class),
        ];
    }

}
