<?php

namespace LaravelGreatApi\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/**
 * @method string statusText()
 * @method array data()
 */
class Response implements Responsable
{
    private array $errorMessages = [
        //
    ];

	/**
	 * Undocumented variable
	 *
	 * @var array|null
	 */
	private ?array $arguments = null;

	/**
	 * Constructor
	 *
	 * @param array $arguments
	 */
	public function __construct($arguments = [])
	{
		$this->arguments = is_array($arguments) ? $arguments : func_get_args();
	}

    /**
     * Undocumented function
     *
     * @param string $method
     * @return mixed
     */
    private function callMethod(string $method)
    {
        if (\method_exists($this, $method)) {
            if ($this->arguments) {
                return $this->{$method}(...array_values($this->arguments));
            }

            return $this->{$method}();
        }

        return null;
    }

    /**
     * Is response invalid?
     *
     * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     *
     * @final
     */
    public function isInvalid(): bool
    {
        return $this->getStatusCode() < 100 || $this->getStatusCode() >= 600;
    }

    /**
     * Is response informative?
     *
     * @final
     */
    public function isInformational(): bool
    {
        return $this->getStatusCode() >= 100 && $this->getStatusCode() < 200;
    }

    /**
     * Is response successful?
     *
     * @final
     */
    public function isSuccessful(): bool
    {
        return $this->getStatusCode() >= 200 && $this->getStatusCode() < 300;
    }

    /**
     * Is the response a redirect?
     *
     * @final
     */
    public function isRedirection(): bool
    {
        return $this->getStatusCode() >= 300 && $this->getStatusCode() < 400;
    }

    /**
     * Is there a client error?
     *
     * @final
     */
    public function isClientError(): bool
    {
        return $this->getStatusCode() >= 400 && $this->getStatusCode() < 500;
    }

    /**
     * Was there a server side error?
     *
     * @final
     */
    public function isServerError(): bool
    {
        return $this->getStatusCode() >= 500 && $this->getStatusCode() < 600;
    }

    /**
     * Is the response OK?
     *
     * @final
     */
    public function isOk(): bool
    {
        return 200 === $this->getStatusCode();
    }

    /**
     * Is the response forbidden?
     *
     * @final
     */
    public function isForbidden(): bool
    {
        return 403 === $this->getStatusCode();
    }

    /**
     * Is the response a not found error?
     *
     * @final
     */
    public function isNotFound(): bool
    {
        return 404 === $this->getStatusCode();
    }

    /**
     * Is the response a redirect of some form?
     *
     * @final
     */
    public function isRedirect(string $location = null): bool
    {
        return \in_array($this->getStatusCode(), [201, 301, 302, 303, 307, 308]) && (null === $location ?: $location == $this->headers->get('Location'));
    }

    /**
     * Is the response empty?
     *
     * @final
     */
    public function isEmpty(): bool
    {
        return \in_array($this->getStatusCode(), [204, 304]);
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    private function getStatusCode(): int
    {
        return $this->callMethod('status') ?? HttpFoundationResponse::HTTP_OK;
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    private function getStatusText()
    {
        if ($this->isSuccessful() === false) {
            return $this->callMethod('statusText') ?? HttpFoundationResponse::$statusTexts[$this->getStatusCode()];
        }

        return null;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    private function getErrorMessage(): ?string
    {
        if ($this->isSuccessful() === false) {
            return $this->callMethod('errorMessage') ?? $this->errorMessages[$this->getStatusCode()] ?? "";
        }

        return null;
    }

    /**
     * Undocumented function
     *
     * @return array|null
     */
    private function getData(): ?array
    {
        if ($this->isSuccessful()) {
            return $this->callMethod('data') ?? [];
        }

        return null;
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return mixed
     */
    public function toArray($request)
    {
        return array_filter([
            'error' => $this->getStatusText(),
            'message' => $this->getErrorMessage(),
            'data' => $this->getData(),
            'success' => $this->isSuccessful(),
            'status' => $this->getStatusCode()
        ], fn($value) => !is_null($value));
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->callMethod('headers') ?? [];
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Http\Response $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return new JsonResponse(
            $this->toArray($request),
            $this->getStatusCode(),
            $this->getHeaders()
        );
    }
}
