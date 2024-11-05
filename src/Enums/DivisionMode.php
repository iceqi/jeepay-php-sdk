<?php

namespace Reprover\Jeepay\Enums;

class DivisionMode
{
    const DISABLED = 0;
    const AUTO = 1;
    const MANUAL = 2;

    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function from($value)
    {
        $constants = (new \ReflectionClass(__CLASS__))->getConstants();
        if (!in_array($value, $constants, true)) {
            throw new \InvalidArgumentException("Invalid value for DivisionMode: $value");
        }
        return new self($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}