<?php

namespace LaravelGreatApi\Response\Responses;

use LaravelGreatApi\Response\Concerns\HasStatusText;
use LaravelGreatApi\Response\Contracts\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use LaravelGreatApi\Response\Response as LaravelApiResponse;

class InternalServerErrorResponse extends LaravelApiResponse implements ErrorResponse
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
	public function __construct(string $message = 'An unexpected error has occurred')
	{
		$this->message = $message;
	}

	/**
	 * Get Response Message
	 *
	 * @return string
	 */
	public function message(): string
	{
		return $this->message;
	}

	/**
	 * Get Response Status
	 *
	 * @return integer
	 */
	public function status(): int
	{
		return Response::HTTP_INTERNAL_SERVER_ERROR;
	}
}
