<?php

namespace LaravelGreatApi\Response\Responses;

use LaravelGreatApi\Response\Concerns\HasStatusText;
use LaravelGreatApi\Response\Contracts\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use LaravelGreatApi\Response\Response as LaravelApiResponse;

class UnauthorizedResponse extends LaravelApiResponse implements ErrorResponse
{
	use HasStatusText;

	public function __construct(?string $message = 'Authentication Required')
	{
		$this->setErrorMessage($message);

		$this->setStatus(Response::HTTP_UNAUTHORIZED);
	}
}
