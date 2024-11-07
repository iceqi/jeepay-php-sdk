<?php

namespace Muzi\Jeepay\Request;

use GuzzleHttp\Exception\GuzzleException;
use Muzi\Jeepay\Enums\AccountType;
use Muzi\Jeepay\Enums\DivisionRelationType;
use Muzi\Jeepay\Enums\IfCode;
use Muzi\Jeepay\Exceptions\HttpException;
use Muzi\Jeepay\Exceptions\JeepayException;
use Muzi\Jeepay\Support\JeepayClient;

final class Division extends JeepayClient
{
    const DIVISION_PREFIX = self::COMMON_PREFIX . '/division';
    const DIVISION_BIND = self::DIVISION_PREFIX . '/receiver/bind';
    const DIVISION_EXEC = self::DIVISION_PREFIX . '/exec';

    /**
     * 绑定接收者
     *
     * @param string $if_code 接口代码
     * @param string $receiver_alias 接收者别名
     * @param int $receiver_group_id 接收者组ID
     * @param AccountType $acc_type 账户类型
     * @param string $acc_no 账户号码
     * @param string|null $acc_name 账户名称（可空）
     * @param DivisionRelationType $relation_type 分组关系类型
     * @param string|null $relation_type_name 分组关系名称（可空）
     * @param string|null $channel_ext_info 渠道扩展信息（可空）
     * @param string $division_profit 分润利润
     *
     * @return array{
     *     accName: string,
     *     accNo: string,
     *     accType: int,
     *     appId: string,
     *     bindState: int,
     *     divisionProfit: string,
     *     errCode: string,
     *     errMsg: string,
     *     ifCode: string,
     *     mchNo: string,
     *     receiverAlias: string,
     *     receiverGroupId: int,
     *     relationType: string,
     *     relationTypeName: string
     *     }
     * @throws GuzzleException
     * @throws HttpException
     * @throws JeepayException
     */
    public function bind(
        string $if_code,
        string $receiver_alias,
        int $receiver_group_id,
        AccountType $acc_type,
        string $acc_no,
        ?string $acc_name,
        DivisionRelationType $relation_type,
        ?string $relation_type_name,
        ?string $channel_ext_info,
        string $division_profit
    ): array {
        $params = [
            'if_code' => $if_code,
            'receiver_alias' => $receiver_alias,
            'receiver_group_id' => $receiver_group_id,
            'acc_type' => $acc_type->value,
            'acc_no' => $acc_no,
            'acc_name' => $acc_name,
            'relation_type' => $relation_type->value,
            'relation_type_name' => $relation_type_name,
            'channel_ext_info' => $channel_ext_info,
            'division_profit' => $division_profit,
        ];

        return $this->postForm(self::DIVISION_BIND, $params)->toArray();
    }

    /**
     * 执行分润
     *
     * @param string|null $pay_order_id 支付订单ID
     * @param string|null $mch_order_no 商户订单号
     * @param bool $use_sys_auto_division_receivers 是否使用系统自动接收者
     * @param array|null $receivers 接收者列表（可空）
     *
     * @return array{
     *     channelBatchOrderId: string,
     *     errCode: string,
     *     errMsg: string,
     *     state: int
     * }
     * @throws GuzzleException
     * @throws HttpException
     * @throws JeepayException
     */
    public function exec(
        ?string $pay_order_id,
        ?string $mch_order_no,
        bool $use_sys_auto_division_receivers,
        ?array $receivers = []
    ): array {
        if ($pay_order_id === null && $mch_order_no === null) {
            throw new \InvalidArgumentException('pay_order_id and mch_order_no cannot be null at the same time.');
        }

        $params = [
            'pay_order_id' => $pay_order_id,
            'mch_order_no' => $mch_order_no,
            'use_sys_auto_division_receivers' => $use_sys_auto_division_receivers ? 1 : 0,
            'receivers' => $use_sys_auto_division_receivers ? null : $receivers,
        ];

        return $this->postForm(self::DIVISION_EXEC, array_filter($params))->toArray();
    }
}