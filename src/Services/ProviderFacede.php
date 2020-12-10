<?php

namespace App\Services;

class ProviderFacede
{
    /**
     * @var ProviderFactory
     */
    private $factory;

    /**
     * ProviderFacede constructor.
     *
     * @param ProviderFactory $factory
     */
    public function __construct(ProviderFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->factory->get();
    }
}
