<?php

namespace App\Services\Providers;

use App\Services\ProviderAbstract;
use App\Services\ProviderModel;

class Provider2Service extends ProviderAbstract
{
    /**
     * @var string
     */
    protected $endPoint = 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7';

    /**
     * @return array
     */
    public function get(): array
    {
        $items = [];
        foreach ($this->rest('get') as $key => $item) {
            $title = key($item);
            $model = new ProviderModel();
            $model->setServiceName('Provider2');
            $model->setId($key);
            $model->setTitle($title);
            $model->setTime($item[$title]['estimated_duration']);
            $model->setLevel($item[$title]['level']);

            $items[] = $model;
        }

        return $items;
    }
}