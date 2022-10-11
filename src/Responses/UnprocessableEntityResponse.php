<?php

namespace LaravelGreatApi\Response\Responses;

use Symfony\Component\HttpFoundation\Response;
use LaravelGreatApi\Response\Concerns\HasStatusText;
use LaravelGreatApi\Response\Contracts\ErrorResponse;
use LaravelGreatApi\Response\Response as LaravelApiResponse;

class UnprocessableEntityResponse extends LaravelApiResponse implements ErrorResponse
{
	use HasStatusText;

	/**
	 * Error Message
	 *
	 * @var string
	 */
	private string $message;

	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	private array $errors;

	/**
	 * Undocumented function
	 *
	 * @return $this
	 */
	public static function make(): UnprocessableEntityResponse
	{
		return new self;
	}

	/**
	 * Set Error Message
	 *
	 * @param string $message
	 * @return $this
	 */
	public function setMessage(string $message): UnprocessableEntityResponse
	{
		$this->message = $message;

		return $this;
	}

	/**
	 * Set Error
	 *
	 * @param string $key
	 * @param string $value
	 * @return $this
	 */
	public function setError(string $key, string $value): UnprocessableEntityResponse
	{
		$this->errors[$key][] = $value;

		return $this;
	}

	/**
	 * Set Errors
	 *
	 * @param array $errors
	 * @return $this
	 */
	public function setErrors(array $errors): UnprocessableEntityResponse
	{
		$this->errors = $errors;

		return $this;
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

	public function errors(): array
	{
		return $this->errors;
	}

	/**
	 * Get Response Status
	 *
	 * @return integer
	 */
	public function status(): int
	{
		return Response::HTTP_UNPROCESSABLE_ENTITY;
	}
}
