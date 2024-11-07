<?php

namespace Muzi\Jeepay\Enums;

class WayCode
{
    const QR_CASHIER = 'QR_CASHIER';
    const AUTO_BAR = 'AUTO_BAR';

    const ALI_BAR = 'ALI_BAR';
    const ALI_JSAPI = 'ALI_JSAPI';
    const ALI_APP = 'ALI_APP';
    const ALI_WAP = 'ALI_WAP';
    const ALI_PC = 'ALI_PC';
    const ALI_QR = 'ALI_QR';

    const WX_BAR = 'WX_BAR';
    const WX_JSAPI = 'WX_JSAPI';
    const WX_LITE = 'WX_LITE';
    const WX_APP = 'WX_APP';
    const WX_H5 = 'WX_H5';
    const WX_NATIVE = 'WX_NATIVE';

    const YSF_BAR = 'YSF_BAR';
    const YSF_JSAPI = 'YSF_JSAPI';

    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function from($value)
    {
        $constants = (new \ReflectionClass(__CLASS__))->getConstants();
        if (!in_array($value, $constants, true)) {
            throw new \InvalidArgumentException("Invalid value for WayCode: $value");
        }
        return new self($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
