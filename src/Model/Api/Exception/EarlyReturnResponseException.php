<?php declare(strict_types = 1);

namespace App\Model\Api\Exception;

use App\Model\Exception\RuntimeException;
use Contributte\FrameX\Http\IResponse;

class EarlyReturnResponseException extends RuntimeException
{

	private function __construct(
		private IResponse $response
	)
	{
		parent::__construct();
	}

	public static function from(IResponse $response): self
	{
		return new self($response);
	}

	public function getResponse(): IResponse
	{
		return $this->response;
	}

}
