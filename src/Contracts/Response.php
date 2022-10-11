<?php

namespace LaravelGreatApi\Response\Contracts;

interface Response
{
	/**
	 * Response Data
	 *
	 * @return mixed
	 */
	public function data(): mixed;
}
