<?php

namespace LaravelGreatApi\Response\Concerns;

use Symfony\Component\HttpFoundation\Response;

trait HasStatusText
{
	/**
	 * Get Response Error
	 *
	 * @return string
	 */
	public function statusText(): string
	{
		return Response::$statusTexts[$this->getStatusCode()];
	}
}
