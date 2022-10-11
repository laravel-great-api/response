<?php

namespace LaravelGreatApi\Response\Responses;

use LaravelGreatApi\Response\Contracts\Response;
use Laravel\Sanctum\NewAccessToken;
use LaravelGreatApi\Response\Response as LaravelApiResponse;

class PersonalAccessTokenResponse extends LaravelApiResponse implements Response
{
	/**
	 * New Access Token
	 *
	 * @var NewAccessToken
	 */
	private NewAccessToken $newAccessToken;

	/**
	 * Create New Instance
	 *
	 * @param NewAccessToken $newAccessToken
	 */
	public function __construct(NewAccessToken $newAccessToken)
	{
		$this->newAccessToken = $newAccessToken;
	}

	/**
	 * Response Data
	 *
	 * @return mixed
	 */
	public function data(): mixed
	{
		return ['token' => $this->newAccessToken->plainTextToken];
	}
}
