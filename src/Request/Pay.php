<?php

namespace Muzi\Jeepay\Request;

use Muzi\Jeepay\Enums\DivisionMode;
use Muzi\Jeepay\Support\JeepayClient;
use Muzi\Jeepay\Exceptions\HttpException;
use Muzi\Jeepay\Exceptions\JeepayException;
use GuzzleHttp\Exception\GuzzleException;

final class Pay extends JeepayClient
{
    const PAY_URL = self::COMMON_PREFIX . "/pay";
    const UNIFIED_ORDER_URL = self::PAY_URL . '/unifiedOrder';
    const QUERY_URL = self::PAY_URL . '/query';
    const CLOSE_URL = self::PAY_URL . '/close';

    /**
     * 统一下单
     *
     * @param string $mch_order_no
     * @param string $way_code
     * @param int $amount
     * @param string $subject
     * @param string $body
     * @param array $channel_extra
     * @param string|null $notify_url
     * @param string|null $return_url
     * @param int|null $expired_time
     * @param string|null $client_ip
     * @param string|null $ext_param
     * @param int $division_mode
     * @return array
     * @throws HttpException
     * @throws JeepayException
     * @throws GuzzleException
     */
    public function unifiedOrder(
        string $mch_order_no,
        string $way_code,
        int $amount,
        string $subject,
        string $body,
        array $channel_extra = [],
        ?string $notify_url = null,
        ?string $return_url = null,
        ?int $expired_time = null,
        ?string $client_ip = null,
        ?string $ext_param = null,
        int $division_mode = DivisionMode::AUTO
    ): array {
        $params = array_filter([
            'mchOrderNo' => $mch_order_no,
            'wayCode' => $way_code,
            'amount' => $amount,
            'currency' => 'cny',
            'subject' => $subject,
            'body' => $body,
            'notifyUrl' => $notify_url,
            'returnUrl' => $return_url,
            'expiredTime' => $expired_time,
            'channelExtra' => json_encode($channel_extra),
            'clientIp' => $client_ip,
            'divisionMode' => $division_mode,
            'extParam' => $ext_param,
        ], function ($value) {
            return !is_null($value);
        });
       
        return $this->postForm(self::UNIFIED_ORDER_URL, $params)->toArray();
    }

    /**
     * 查询订单
     *
     * @param string|null $pay_order_id
     * @param string|null $mch_order_no
          * @return array{
     *     amount: int,
     *     appId: string,
     *     body: string,
     *     channelOrderNo: string,
     *     clientIp: string,
     *     createdAt: int,
     *     currency: string,
     *     extParam: string,
     *     ifCode: string,
     *     mchNo: string,
     *     mchOrderNo: string,
     *     payOrderId: string,
     *     state: int,
     *     subject: string,
     *     successTime: int,
     *     wayCode: string,
     *     errCode: string,
     *     errMsg: string,
     * }
     * @throws HttpException
     * @throws JeepayException
     * @throws GuzzleException
     */
    public function query(?string $pay_order_id = null, ?string $mch_order_no = null): array
    {
        if ($pay_order_id === null && $mch_order_no === null) {
            throw new \InvalidArgumentException('One of payOrderId and mchOrderNo is required');
        }

        $params = array_filter([
            'payOrderId' => $pay_order_id,
            'mchOrderNo' => $mch_order_no,
        ], function ($value) {
            return !is_null($value);
        });

        return $this->postForm(self::QUERY_URL, $params)->toArray();
    }

    /**
     * 关闭订单
     *
     * @param string|null $pay_order_id
     * @param string|null $mch_order_no
     * @return array
     * @throws HttpException
     * @throws JeepayException
     * @throws GuzzleException
     */
    public function close(?string $pay_order_id = null, ?string $mch_order_no = null): array
    {
        if ($pay_order_id === null && $mch_order_no === null) {
            throw new \InvalidArgumentException('One of payOrderId and mchOrderNo is required');
        }

        $params = array_filter([
            'payOrderId' => $pay_order_id,
            'mchOrderNo' => $mch_order_no,
        ], function ($value) {
            return !is_null($value);
        });

        return $this->postForm(self::CLOSE_URL, $params)->toArray();
    }
}