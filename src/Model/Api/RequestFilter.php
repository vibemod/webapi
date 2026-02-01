<?php declare(strict_types = 1);

namespace App\Model\Api;

use Nette\Schema\Elements\Structure;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class RequestFilter
{

	/** @var array<string, array<scalar>|scalar>|null */
	public ?array $q = null;

	public ?string $qs = null;

	public ?int $p = null;

	public ?int $l = null;

	/** @var array<string, 'desc'|'asc'>|null */
	public ?array $o = null;

	/**
	 * @return array<string, Schema>
	 */
	public static function shared(): array
	{
		return [
			'p' => Expect::string()->castTo('int')->default(1),
			'l' => Expect::string()->castTo('int')->default(1000),
			'o' => Expect::structure([])->required(false)->castTo('array'),
			'q' => Expect::structure([])->required(false)->castTo('array'),
			'qs' => Expect::string(),
		];
	}

	/**
	 * @param array<string, Schema> $overrides
	 */
	public static function extend(array $overrides): Structure
	{
		return Expect::structure(
			array_merge(self::shared(), $overrides)
		);
	}

	/**
	 * @return array{
	 *     q: array<string, array<scalar>|scalar>|null,
	 *     qs: string|null,
	 *     p: int|null,
	 *     l: int|null,
	 *     o: array<string, 'desc'|'asc'>|null
	 * }
	 */
	public function toArray(): array
	{
		$data = [];

		$data['q'] = $this->q;
		$data['qs'] = $this->qs;
		$data['p'] = $this->p;
		$data['l'] = $this->l;
		$data['o'] = $this->o;

		return $data;
	}

}
