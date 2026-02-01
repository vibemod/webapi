<?php declare(strict_types = 1);

namespace App\Api;

use App\Model\Api\Exception\EarlyReturnResponseException;
use App\Model\Api\Exception\InvalidRequestException;
use App\Model\Doctrine\Exception\EntityNotFoundException;
use Contributte\FrameX\Http\ErrorResponse;
use Contributte\FrameX\Http\IResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

abstract class BetterApiController
{

	public function __construct(
		protected readonly LoggerInterface $logger,
	)
	{
	}

	abstract public function invoke(ServerRequestInterface $serverRequest): IResponse;

	public function __invoke(ServerRequestInterface $serverRequest): IResponse
	{
		try {
			return $this->invoke($serverRequest);
		} catch (EarlyReturnResponseException $e) {
			return $e->getResponse();
		} catch (InvalidRequestException $e) {
			return ErrorResponse::create()
				->withStatusCode(400)
				->withErrorCode(400)
				->withMessage($e->getMessage());
		} catch (HandlerFailedException $e) {
			$this->logger->error(sprintf('%s failed', static::class), ['exception' => $e]);

			if ($e->getPrevious() instanceof EntityNotFoundException) {
				return ErrorResponse::create()
					->withStatusCode(404)
					->withErrorCode(404)
					->withMessage($e->getPrevious()->getMessage());
			}

			return ErrorResponse::create()
				->withStatusCode(500)
				->withErrorCode(500)
				->withMessage($e->getPrevious()?->getMessage());
		}
	}

}
