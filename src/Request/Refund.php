<?php

namespace Muzi\Jeepay\Request;

use Muzi\Jeepay\Support\JeepayClient;
use Muzi\Jeepay\Exceptions\HttpException;
use Muzi\Jeepay\Exceptions\JeepayException;
use GuzzleHttp\Exception\GuzzleException;

final class Refund extends JeepayClient
{
    const REFUND_PREFIX = self::COMMON_PREFIX . "/refund";
    const REFUND_ORDER_URL = self::REFUND_PREFIX . '/refundOrder';
    const QUERY_URL = self::REFUND_PREFIX . '/query';

    /**
     * 处理退款订单
     *
     * @param string|null $pay_order_id 支付订单ID
     * @param string|null $mch_order_no 商户订单号
     * @param string $mch_refund_no 商户退款单号
     * @param int $refund_amount 退款金额
     * @param string $refund_reason 退款原因
     * @param array $channel_extra 渠道附加参数
     * @param string|null $notify_url 通知URL
     * @param string|null $client_ip 客户端IP
     * @param string|null $ext_param 扩展参数
     *
     * @return array{
     *      channelOrderNo: string,
     *      mchRefundNo: string,
     *      payAmount: int,
     *      refundAmount: int,
     *      refundOrderId: string,
     *      state: int,
     *  }
     * @throws GuzzleException
     * @throws HttpException
     * @throws JeepayException
     */
    public function refundOrder(
        ?string $pay_order_id,
        ?string $mch_order_no,
        string $mch_refund_no,
        int $refund_amount,
        string $refund_reason,
        array $channel_extra = [],
        ?string $notify_url = null,
        ?string $client_ip = null,
        ?string $ext_param = null
    ): array {
        if (is_null($pay_order_id) && is_null($mch_order_no)) {
            throw new \InvalidArgumentException('One of payOrderId and mchOrderNo is required');
        }

        $params = array_filter([
            'payOrderId' => $pay_order_id,
            'mchOrderNo' => $mch_order_no,
            'mchRefundNo' => $mch_refund_no,
            'refundAmount' => $refund_amount,
            'currency' => 'cny',
            'refundReason' => $refund_reason,
            'channelExtra' => json_encode($channel_extra),
            'notifyUrl' => $notify_url,
            'clientIp' => $client_ip,
            'extParam' => $ext_param,
        ], function ($value) {
            return !is_null($value);
        });

        return $this->postForm(self::REFUND_ORDER_URL, $params)->toArray();
    }

    /**
     * 查询退款订单
     *
     * @param string|null $refund_order_id 退款订单ID
     * @param string|null $mch_refund_no 商户退款单号
     *
         * @return array{
     *     appId: string,
     *     channelOrderNo: string,
     *     createdAt: int,
     *     currency: string,
     *     extParam: string,
     *     mchNo: string,
     *     mchRefundNo: string,
     *     payAmount: int,
     *     payOrderId: string,
     *     refundAmount: int,
     *     refundOrderId: string,
     *     state: int,
     *     successTime: int,
     *     errCode: string,
     *     errMsg: string,
     * }
     * @throws HttpException
     * @throws JeepayException
     * @throws GuzzleException
     */
    public function query(?string $refund_order_id, ?string $mch_refund_no): array
    {
        if (is_null($refund_order_id) && is_null($mch_refund_no)) {
            throw new \InvalidArgumentException('One of refundOrderId and mchRefundNo is required');
        }

        $params = array_filter([
            'refundOrderId' => $refund_order_id,
            'mchRefundNo' => $mch_refund_no,
        ], function ($value) {
            return !is_null($value);
        });

        return $this->postForm(self::QUERY_URL, $params)->toArray();
    }
}