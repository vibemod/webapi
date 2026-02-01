<?php declare(strict_types = 1);

namespace App\Model\Api;

use App\Model\Api\Exception\InvalidRequestException;
use App\Model\Exception\LogicalException;
use Nette\Schema\Processor;
use Nette\Schema\Schema;
use Nette\Schema\ValidationException;
use Nette\Utils\Json;
use Psr\Http\Message\ServerRequestInterface;

class RequestFactory
{

	/**
	 * @template T
	 * @param class-string<T>|null $classType
	 * @return T
	 */
	public function createBody(ServerRequestInterface $serverRequest, Schema $schema, string|null $classType = null)
	{
		try {
			$body = Json::decode((string) $serverRequest->getBody(), forceArrays: true);
			assert(is_array($body));

			$body = $this->process($body, $schema);

			if ($classType !== null) {
				assert($body instanceof $classType);
			}

			return $body;
		} catch (ValidationException $e) {
			throw InvalidRequestException::invalidBody($e);
		}
	}

	/**
	 * @template T
	 * @param class-string<T>|null $classType
	 * @return T
	 */
	public function createQuery(ServerRequestInterface $serverRequest, Schema $schema, string|null $classType = null)
	{
		try {
			$params = $serverRequest->getQueryParams();
			$query = $this->process($params, $schema);

			if ($classType !== null) {
				assert($query instanceof $classType);
			}

			return $query;
		} catch (ValidationException $e) {
			throw InvalidRequestException::invalidQuery($e);
		}
	}

	/**
	 * @template T
	 * @param class-string<T>|null $classType
	 * @return T
	 */
	public function createParameters(ServerRequestInterface $serverRequest, Schema $schema, string|null $classType = null)
	{
		try {
			$params = $serverRequest->getAttributes();
			$parameters = $this->process($params, $schema);

			if ($classType !== null) {
				assert($parameters instanceof $classType);
			}

			return $parameters;
		} catch (ValidationException $e) {
			throw InvalidRequestException::invalidParameters($e);
		}
	}

	/**
	 * @template T
	 * @param class-string<T> $requestClass
	 * @return T
	 */
	public function createRequest(ServerRequestInterface $serverRequest, string $requestClass)
	{
		// Validate method exists
		if (!method_exists($requestClass, 'schema')) {
			throw new LogicalException(sprintf('Class %s must have schema method', $requestClass));
		}

		$schema = $requestClass::schema();
		$args = [];

		if (isset($schema['params'])) {
			$args['params'] = $this->createParameters($serverRequest, $schema['params']); // @phpstan-ignore-line
		}

		if (isset($schema['query'])) {
			$args['query'] = $this->createQuery($serverRequest, $schema['query']); // @phpstan-ignore-line
		}

		if (isset($schema['body'])) {
			$args['body'] = $this->createBody($serverRequest, $schema['body']); // @phpstan-ignore-line
		}

		// Instantiate request class
		/** @var T $request */
		$request = new $requestClass(...$args);

		return $request;
	}

	/**
	 * @param array<mixed> $data
	 */
	private function process(array $data, Schema $schema): mixed
	{
		return (new Processor())->process($schema, $data);
	}

}
