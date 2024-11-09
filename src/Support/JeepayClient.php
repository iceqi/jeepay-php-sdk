<?php

namespace Muzi\Jeepay\Support;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Muzi\Jeepay\Common\JeepayResponse;
use Muzi\Jeepay\Exceptions\HttpException;
use Muzi\Jeepay\Exceptions\JeepayException;

class JeepayClient
{
    use Signature;

    const COMMON_PREFIX = "/api";

    private $baseURL;
    private $mchNo;
    private $appId;
    private $key;

    private $config;
    private $headers = [];
    private $fixedParams = [
        'signType' => 'MD5',
        'version' => '1.0',
    ];
    
    public function __construct(string $baseURL, string $mchNo,string $appId,string $key)
    {
        $this->baseURL = $baseURL;
        $this->mchNo = $mchNo;
        $this->appId = $appId;
        $this->key = $key;
    }

    /**
     * 发送GET请求并获取内容
     *
     * @throws HttpException
     * @throws GuzzleException
     * @throws JeepayException
     */
    public function getContent(string $url, array $params): JeepayResponse
    {
        $data = array_merge($params, $this->fixedParams, $this->addRequiredParams());
        return $this->sendRequest('GET', $url, $data);
    }

    /**
     * 发送POST请求
     *
     * @throws HttpException
     * @throws GuzzleException
     * @throws JeepayException
     */
    public function postForm(string $url, array $data): JeepayResponse
    {
        $data = array_merge($data, $this->fixedParams, $this->addRequiredParams());
        return $this->sendRequest('POST', $url, $data);
    }

    /**
     * 生成完整的URL，附带查询参数
     */
    private function buildURL(string $url, array $params = []): string
    {
        return $params ? $url . '?' . http_build_query($params) : $url;
    }

    /**
     * 发送HTTP请求
     *
     * @throws HttpException
     * @throws GuzzleException
     */
    private function sendRequest(string $method, string $url, array $data = []): JeepayResponse
    {
        $client = new Client(['base_uri' => $this->baseURL]);
        $data = array_merge($data, ['sign' => $this->sign($data, $this->key)]);
        if ($method === 'GET') {
            $url = $this->buildURL($url, $data);
        }
        $response = $client->request($method, $url, [
            'headers'     => $this->headers,
            'form_params' => $method == 'POST' ? $data : [],
        ]);
        $response = $client->request($method, $url, $options);
        if ($response->getStatusCode() !== 200) {
            throw new HttpException("Request failed with status code " . $response->getStatusCode());
        }

        return new JeepayResponse($response->getBody()->getContents(), $this->key);
    }

    /**
     * 添加必要的请求参数
     */
    private function addRequiredParams(): array
    {
        return [
            'mchNo' => $this->mchNo,
            'appId' => $this->appId,
            'reqTime' => Carbon::now()->getTimestampMs(),
        ];
    }
}