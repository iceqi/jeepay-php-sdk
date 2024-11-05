<?php

namespace Reprover\Jeepay\Enums;

class OrderState
{
    const CREATED = 0;
    const PAING = 1;
    const SUCCESS = 2;
    const FAIL = 3;
    const CANCEL = 4;
    const REFUNDED = 5;
    const CLOSED = 6;

    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function from($value)
    {
        $constants = (new \ReflectionClass(__CLASS__))->getConstants();
        if (!in_array($value, $constants, true)) {
            throw new \InvalidArgumentException("Invalid value for OrderState: $value");
        }
        return new self($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
