<?php

namespace LaravelGreatApi\Response\Responses;

use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;
use LaravelGreatApi\Response\Response as LaravelApiResponse;

class NoContentResponse extends LaravelApiResponse implements Responsable
{
	public function __construct()
	{
		$this->setStatus(Response::HTTP_NO_CONTENT);
	}
}
