<?php

namespace LaravelGreatApi\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response as HttpResponse;

/**
 * @method mixed statusText
 * @method mixed data
 */
class Response implements Responsable
{
	private mixed $data = null;

	private int $status = HttpResponse::HTTP_OK;

	private $errorMessage = null;

	private array $headers = [];

	public function __construct(mixed $data, int $status = HttpResponse::HTTP_OK, $headers = [])
	{
		$this->data = $data;
		$this->status = $status;
		$this->headers = $headers;
	}

	/**
	 * Undocumented function
	 *
	 * @return integer
	 */
	protected function getStatusCode(): int
	{
		return $this->status;
	}

	private function getData()
	{
		if (method_exists($this, 'data')) {
			return $this->data();
		}

		return $this->data;
	}

	/**
	 * Is Response Success
	 *
	 * @return boolean
	 */
	private function isResponseSuccess(): bool
	{
		return $this->getStatusCode() >= 200 && $this->getStatusCode() < 300;
	}

	/**
	 * Undocumented function
	 *
	 * @return array
	 */
	private function defaultHeaders(): array
	{
		return ['Content-Type' => 'application/json'];
	}

	/**
	 * Undocumented function
	 *
	 * @return array
	 */
	private function getHeaders(): array
	{
		return array_merge($this->headers, $this->defaultHeaders());
	}

	private function getTextStatus()
	{
		if (method_exists($this, 'statusText')) {
			return $this->statusText();
		}

		return null;
	}

	protected function setErrorMessage($message)
	{
		$this->errorMessage = $message;
	}

	protected function setStatus($status)
	{
		$this->status = $status;
	}

	/**
	 * Undocumented function
	 *
	 * @return array
	 */
	private function toArray(): array
	{
		if ($this->status === HttpResponse::HTTP_NO_CONTENT) {
			return [];
		}

		return array_filter([
			'error' => $this->getTextStatus(),
			'message' => $this->errorMessage,
			'data' => $this->getData(),
			'success' => $this->isResponseSuccess(),
			'status' => $this->getStatusCode()
		], fn($value) => !is_null($value));
	}

	/**
	 * Undocumented function
	 *
	 * @return string|false
	 */
	private function toJson(): string|false
	{
		return json_encode($this->toArray());
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $request
	 * @return \Illuminate\Http\Response
	 */
	public function toResponse($request)
	{
		return new HttpResponse(
			$this->toJson(),
			$this->getStatusCode(),
			$this->getHeaders()
		);
	}
}
