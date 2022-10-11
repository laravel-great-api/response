<?php

namespace LaravelGreatApi\Response\Responses;

use LaravelGreatApi\Response\Concerns\HasStatusText;
use LaravelGreatApi\Response\Contracts\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use LaravelGreatApi\Response\Response as LaravelApiResponse;

class ForbiddenResponse extends LaravelApiResponse implements ErrorResponse
{
	use HasStatusText;

	/**
	 * Error Message
	 *
	 * @var string
	 */
	private string $message;

	/**
	 * Create New Instance
	 *
	 * @param string $message
	 */
	public function __construct(string $message = 'Access Denied')
	{
		$this->setErrorMessage($message);

		$this->setStatus(Response::HTTP_FORBIDDEN);
	}
}
