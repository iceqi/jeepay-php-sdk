<?php

namespace Reprover\Jeepay\Enums;

class RefundState
{
    const CREATED = 0;
    const REFUNDING = 1;
    const SUCCESS = 2;
    const FAIL = 3;
    const CLOSED = 4;

    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function from($value)
    {
        $constants = (new \ReflectionClass(__CLASS__))->getConstants();
        if (!in_array($value, $constants, true)) {
            throw new \InvalidArgumentException("Invalid value for RefundState: $value");
        }
        return new self($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
