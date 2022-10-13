<?php

namespace LaravelGreatApi\Response;

class JsonResponse extends Response
{
    /**
     * Undocumented variable
     *
     * @var mixed
     */
    private mixed $data;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private int $status;

    /**
     * Undocumented variable
     *
     * @var array
     */
    private array $headers;

    /**
     * Constructor
     *
     * @param mixed $data
     * @param integer $status
     * @param array $headers
     */
    public function __construct(mixed $data = null, int $status = 200, array $headers = [])
    {
        $this->data = $data;
        $this->status = $status;
        $this->headers = $headers;
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    protected function data(): mixed
    {
        return $this->data;
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    protected function status(): int
    {
        return $this->status;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function headers(): array
    {
        return $this->headers;
    }
}
