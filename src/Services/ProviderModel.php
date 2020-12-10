<?php

namespace App\Services;

class ProviderModel
{
    public $serviceName;

    public $id;

    public $title;

    public $time;

    public $level;

    public function setServiceName($value): void
    {
        $this->serviceName = $value;
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function setTitle($value): void
    {
        $this->title = $value;
    }

    public function setTime($value): void
    {
        $this->time = $value;
    }

    public function setLevel($value): void
    {
        $this->level = $value;
    }
}
