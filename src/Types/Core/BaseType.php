<?php

namespace BrianRLewis\MagicAdmin\Types\Core;

class BaseType
{
    protected $data;

    public function toArray(): array
    {
        return array_map(function ($value) {
            if ($value instanceof self) {
                return $value->toArray();
            } else {
                return $value;
            }
        }, $this->data);
    }
}
