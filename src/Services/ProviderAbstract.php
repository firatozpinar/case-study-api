<?php

namespace App\Services;

use GuzzleHttp\Client;

abstract class ProviderAbstract implements ProviderContract
{
    /**
     * Guzzle
     *
     * @var Client
     */
    protected $client;

    /**
     * End point url
     *
     * @var string
     */
    protected $endPoint;

    /**
     * ProviderAbstract constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param       $method
     * @param array $params
     * @return mixed
     */
    public function rest($method, $params = [])
    {
        if (!method_exists($this->client, $method)) {
            throw new \RuntimeException($method . ' method not found!');
        }

        return $this->response($this->client->{$method}($this->endPoint, $params));
    }

    /**
     * @param $response
     * @return array
     */
    protected function response($response): array
    {
        return json_decode((string)$response->getBody(), true);
    }
}
