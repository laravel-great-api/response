<?php

namespace LaravelGreatApi\Response;

class ResponseHandler
{
	public static function handle($response)
	{
		if (is_array($response) || is_numeric($response) || is_string($response)) {
			return new Response($response);
		}

		return $response;
	}
}
