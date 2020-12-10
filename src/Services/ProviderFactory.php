<?php

namespace App\Services;

class ProviderFactory
{
    /**
     * Provider service
     *
     * @var
     */
    protected $service;

    /**
     * ProviderFactory constructor.
     *
     * @param string $name
     * @throws \Exception
     */
    public function __construct(string $name)
    {
        $this->load($name);
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    protected function load($name)
    {
        $className = '\App\Services\Providers\\'. $name .'Service';

        if (!class_exists($className)) {
            throw new \RuntimeException($name. ' not found!');
        }

        return $this->service = new $className;
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function get($filters = [])
    {
        return $this->service->get($filters);
    }
}
