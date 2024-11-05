<?php

namespace Reprover\Jeepay\Enums;

/**
 * 分账关系类型：
 * SERVICE_PROVIDER：服务商
 * STORE：门店
 * STAFF：员工
 * STORE_OWNER：店主
 * PARTNER：合作伙伴
 * HEADQUARTER：总部
 * BRAND：品牌方
 * DISTRIBUTOR：分销商
 * USER：用户
 * SUPPLIER：供应商
 * CUSTOM：自定义
 */
class DivisionRelationType
{
    const SERVICE_PROVIDER = 'SERVICE_PROVIDER';
    const STORE = 'STORE';
    const STAFF = 'STAFF';
    const STORE_OWNER = 'STORE_OWNER';
    const PARTNER = 'PARTNER';
    const HEADQUARTER = 'HEADQUARTER';
    const BRAND = 'BRAND';
    const DISTRIBUTOR = 'DISTRIBUTOR';
    const USER = 'USER';
    const SUPPLIER = 'SUPPLIER';
    const CUSTOM = 'CUSTOM';

    public $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function from($value)
    {
        $constants = (new \ReflectionClass(__CLASS__))->getConstants();
        if (!in_array($value, $constants, true)) {
            throw new \InvalidArgumentException("Invalid value for DivisionRelationType: $value");
        }
        return new self($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}