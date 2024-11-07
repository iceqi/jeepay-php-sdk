<?php

namespace Muzi\Jeepay\Enums;

class IfCode
{
    const WECHATPAY = 'wxpay';
    const ALIPAY = 'alipay';

    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function from($value)
    {
        $constants = (new \ReflectionClass(__CLASS__))->getConstants();
        if (!in_array($value, $constants, true)) {
            throw new \InvalidArgumentException("Invalid value for IfCode: $value");
        }
        return new self($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}

// 使用示例
//try {
//    $ifCode = IfCode::from('wxpay');
//    echo "IfCode value: " . $ifCode->getValue();  // Outputs: IfCode value: wxpay
//} catch (\InvalidArgumentException $e) {
//    echo $e->getMessage();
//}