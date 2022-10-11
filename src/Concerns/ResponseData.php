<?php

namespace LaravelGreatApi\Response\Concerns;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait ResponseData
{
	/**
	 * Ответ
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function toResponse($request)
	{
		return new Response(
			$this->baseData($request),
			$this->getStatusCode()
		);
	}

	/**
	 * Undocumented function
	 *
	 * @param string $method
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	private function callMethod(string $method, Request $request): mixed
	{
		if (method_exists($this, $method)) {
			return $this->{$method}($request);
		}

		return null;
	}

	/**
	 * Undocumented function
	 *
	 * @return boolean
	 */
	private function isSuccess(): bool
	{
		return $this->getStatusCode() >= 200 && $this->getStatusCode() < 300;
	}

	/**
	 * Получить код статуса
	 *
	 * @return integer
	 */
	protected function getStatusCode(): int
	{
		return $this->status();
	}

	/**
	 * Базовая структура данных для ответа
	 *
	 * @param Request $request
	 * @return array
	 */
	protected function baseData(Request $request): array
	{
		return array_filter([
			'error' => $this->callMethod('error', $request),
			'message' => $this->callMethod('message', $request),
			'errors' => $this->callMethod('errors', $request),
			'data' => $this->callMethod('data', $request),
			'success' => $this->isSuccess(),
			'status' => $this->getStatusCode()
		], fn($value) => !is_null($value));
	}
}
