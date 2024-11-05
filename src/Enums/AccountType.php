<?php

namespace Reprover\Jeepay\Enums;

class AccountType
{
    const PERSONAL = 0;
    const ENTERPRISE = 1;

    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function from($value)
    {
        $constants = (new \ReflectionClass(__CLASS__))->getConstants();
        if (!in_array($value, $constants, true)) {
            throw new \InvalidArgumentException("Invalid value for AccountType: $value");
        }
        return new self($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
