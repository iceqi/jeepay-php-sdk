<?php

namespace Muzi\Jeepay\Request;

use Muzi\Jeepay\Enums\EntryType;
use Muzi\Jeepay\Enums\IfCode;
use Muzi\Jeepay\Support\JeepayClient;
use Muzi\Jeepay\Exceptions\HttpException;
use Muzi\Jeepay\Exceptions\JeepayException;
use GuzzleHttp\Exception\GuzzleException;

final class Transfer extends JeepayClient
{
    const TRANSFER_PREFIX = self::COMMON_PREFIX . "/transfer";
    const TRANSFER_ORDER_URL = self::TRANSFER_PREFIX . '/order';
    const QUERY_URL = self::TRANSFER_PREFIX . '/query';

    /**
     * 执行转账操作
     *
     * @param IfCode $if_code 接口代码
     * @param EntryType $entry_type 进入类型
     * @param int $amount 转账金额
     * @param string $account_no 收款账户号码
     * @param string|null $account_name 收款账户名称（可空）
     * @param string|null $bank_name 银行名称（可空）
     * @param string|null $client_ip 客户端IP（可空）
     * @param string|null $transfer_desc 转账描述（可空）
     * @param string|null $notify_url 通知URL（可空）
     * @param string|null $channel_extra 渠道扩展信息（可空）
     * @param string|null $ext_param 扩展参数（可空）
     *
     * @return array{
     *     accountNo: string,
     *     amount: int,
     *     channelOrderNo: string,
     *     mchOrderNo: string,
     *     state: int,
     *     transferId: string
     *  }
     * @throws GuzzleException
     * @throws HttpException
     * @throws JeepayException
     */
    public function transferOrder(
        string $if_code,
        string $entry_type,
        int $amount,
        string $account_no,
        ?string $account_name = null,
        ?string $bank_name = null,
        ?string $client_ip = null,
        ?string $transfer_desc = null,
        ?string $notify_url = null,
        ?string $channel_extra = null,
        ?string $ext_param = null
    ): array {
        $params = array_filter([
            'ifCode' => $if_code->value,
            'entryType' => $entry_type->value,
            'amount' => $amount,
            'currency' => 'cny',
            'accountNo' => $account_no,
            'accountName' => $account_name,
            'bankName' => $bank_name,
            'clientIp' => $client_ip,
            'transferDesc' => $transfer_desc,
            'notifyUrl' => $notify_url,
            'channelExtra' => $channel_extra,
            'extParam' => $ext_param,
        ], function ($value) {
            return !is_null($value);
        });

        return $this->postForm(self::TRANSFER_ORDER_URL, $params)->toArray();
    }

    /**
     * 查询转账订单
     *
     * @param string|null $transfer_id 转账ID
     * @param string|null $mch_order_no 商户订单号
     * @return array{
     *     accountName: string,
     *     accountNo: string,
     *     amount: int,
     *     appId: string,
     *     bankName: string,
     *     channelOrderNo: string,
     *     createdAt: int,
     *     currency: string,
     *     entryType: string,
     *     errCode: string,
     *     errMsg: string,
     *     extraParam: string,
     *     ifCode: string,
     *     mchNo: string,
     *     mchOrderNo: string,
     *     state: int,
     *     transferDesc: string,
     *     transferId: string,
     *     createdAt: int,
     *     successTime: int
     * }
     * @throws HttpException
     * @throws JeepayException
     * @throws GuzzleException
     */
    public function query(?string $transfer_id, ?string $mch_order_no): array
    {
        if (is_null($transfer_id) && is_null($mch_order_no)) {
            throw new \InvalidArgumentException('One of transferId and mchOrderNo is required');
        }

        $params = array_filter([
            'transferId' => $transfer_id,
            'mchOrderNo' => $mch_order_no,
        ], function ($value) {
            return !is_null($value);
        });

        return $this->postForm(self::QUERY_URL, $params)->toArray();
    }
}