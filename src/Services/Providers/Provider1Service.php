<?php

namespace App\Services\Providers;

use App\Services\ProviderAbstract;
use App\Services\ProviderModel;

class Provider1Service extends ProviderAbstract
{
    /**
     * @var string
     */
    protected $endPoint = 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa';

    /**
     * @return array
     */
    public function get(): array
    {
        $items = [];

        foreach ($this->rest('get') as $key => $item) {
            $model = new ProviderModel();
            $model->setServiceName('Provider1');
            $model->setId($key);
            $model->setTitle($item['id']);
            $model->setTime($item['sure']);
            $model->setLevel($item['zorluk']);

            $items[] = $model;
        }

        return $items;
    }
}