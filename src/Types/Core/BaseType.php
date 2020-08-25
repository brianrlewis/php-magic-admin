<?php

namespace BrianRLewis\MagicAdmin\Types\Core;

class BaseType
{
    protected $data;

    public function toArray(): array
    {
        return $this->data;
    }
}
