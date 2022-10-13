<?php

namespace LaravelGreatApi\Response;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ErrorHandler extends Response
{
    /**
     * Undocumented variable
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
     * Undocumented function
     *
     * @param \Throwable $exception
     */
    public function __construct(Throwable $exception)
    {
        $this->exception = $exception;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    protected function errorMessage(): string
    {
        if ($this->exception instanceof NotFoundHttpException || $this->exception instanceof ModelNotFoundException) {
            return "Resource Not Found";
        }

        return $this->exception->getMessage();
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
     * @return void
     */
    protected function status()
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
