<?php

namespace BrianRLewis\MagicAdmin\Types;

use BrianRLewis\MagicAdmin\Types\Core\BaseType;
use ArrayAccess;

class ParsedDIDToken extends BaseType implements ArrayAccess
{
    public $proof;
    public $claim;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->proof = $data[0];
        $this->claim = $data[1];
    }

    public function offsetExists($name)
    {
        return isset($this->data[$name]);
    }

    public function offsetGet($name)
    {
        return $this->data[$name];
    }

    public function offsetSet($name, $value)
    {
    }

    public function offsetUnset($name)
    {
    }
}
