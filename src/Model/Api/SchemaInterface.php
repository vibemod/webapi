<?php declare(strict_types = 1);

namespace App\Model\Api;

use Nette\Schema\Schema;

interface SchemaInterface
{

	/**
	 * @return array<string, Schema>
	 */
	public static function schema(): array;

}
