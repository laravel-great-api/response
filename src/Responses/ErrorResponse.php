<?php

namespace LaravelGreatApi\Response\Responses;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Responsable;
use LaravelGreatApi\Response\Concerns\ResponseData;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Throwable;

class ErrorResponse implements Responsable
{
	use ResponseData;

	/**
	 * Exception
	 *
	 * @var Throwable
	 */
	private Throwable $exception;

	/**
	 * Error CLasses
	 *
	 * @var array
	 */
	private array $statusCodes = [
		NotFoundHttpException::class => 404,
		ModelNotFoundException::class => 404,
		AuthorizationException::class => 401,
		AuthenticationException::class => 401,
		ValidationException::class => 422,
	];

	/**
	 * Constructor
	 *
	 * @param \Throwable $e
	 */
	public function __construct(Throwable $e)
	{
		$this->exception = $e;
	}

	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	protected function error(): string
	{
		return Response::$statusTexts[$this->status()];
	}

	/**
	 * Undocumented function
	 *
	 * @return array|null
	 */
	protected function errors(): ?array
	{
		if (method_exists($this->exception, 'errors')) {
			return $this->exception->errors();
		}

		return null;
	}

	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	protected function message(): string
	{
		return $this->exception->getMessage();
	}

	/**
	 * Undocumented function
	 *
	 * @return integer
	 */
	protected function status(): int
	{
		if ($code = ($this->statusCodes[$this->exception::class] ?? null)) {
			return $code;
		}

		if (method_exists($this->exception, 'getStatusCode')) {
			return $this->exception->getStatusCode();
		}

		return 500;
	}
}
