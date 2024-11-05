<?php

namespace Reprover\Jeepay\Enums;

class EntryType
{
    const WECHAT_CASH = 'WX_CASH';
    const ALIPAY_CASH = 'ALIPAY_CASH';
    const BANK_CARD = 'BANK_CARD';
    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function from($value)
    {
        $constants = (new \ReflectionClass(__CLASS__))->getConstants();
        if (!in_array($value, $constants, true)) {
            throw new \InvalidArgumentException("Invalid value for EntryType: $value");
        }
        return new self($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}