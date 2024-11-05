<?php

namespace Reprover\Jeepay\Enums;

class PayDataType
{
    const PAY_URL = 'payUrl';

    const FORM = 'form';

    const WXAPP = 'wxapp';

    const ALIAPP = 'aliapp';

    const YSFAPP = 'ysfapp';

    const CODE_URL = 'codeUrl';

    const CODE_IMG_URL = 'codeImgUrl';

    const NONE = 'none';

    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function from($value)
    {
        $constants = (new \ReflectionClass(__CLASS__))->getConstants();
        if (!in_array($value, $constants, true)) {
            throw new \InvalidArgumentException("Invalid value for PayDataType: $value");
        }
        return new self($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
