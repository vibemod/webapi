<?php declare(strict_types = 1);

namespace Tests\Toolkit;

use Tester\FileMutator;

final class Bypass
{

	public static function bypassFinals(): void
	{
		FileMutator::addMutator(static function (string $code): string {
			if (str_contains($code, 'final')) {
				$tokens = \PhpToken::tokenize($code, TOKEN_PARSE);
				$code = '';
				foreach ($tokens as $token) {
					$code .= $token->is(T_FINAL) ? '' : $token->text;
				}
			}

			return $code;
		});
	}

	public static function bypassReadonly(): void
	{
		FileMutator::addMutator(static function (string $code): string {
			if (str_contains($code, 'readonly')) {
				$tokens = \PhpToken::tokenize($code, TOKEN_PARSE);
				$code = '';
				foreach ($tokens as $token) {
					$code .= $token->is(T_READONLY) ? '' : $token->text;
				}
			}

			return $code;
		});
	}

}
