<?php

namespace AdminSDK\Types\Core;

class BaseType
{
    protected $data;

    public function toArray(): array
    {
        return $this->data;
    }
}
