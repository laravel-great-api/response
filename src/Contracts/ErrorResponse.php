<?php

namespace LaravelGreatApi\Response\Contracts;

interface ErrorResponse
{
	/**
	 * Get Response Status Text
	 *
	 * @return string
	 */
	public function statusText(): string;
}
