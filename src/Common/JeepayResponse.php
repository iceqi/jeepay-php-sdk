<?php

namespace Muzi\Jeepay\Common;

use Muzi\Jeepay\Exceptions\JeepayException;
use Muzi\Jeepay\Support\Signature;

class JeepayResponse implements \ArrayAccess
{
    use Signature;

    private $signature;
    private $data;
    private $msg;
    private $code;
    private $key;

    /**
     * JeepayResponse constructor.
     *
     * @param array|string $response 响应数据
     * @param string $key 签名密钥
     * @throws JeepayException
     */
    public function __construct($response, string $key)
    {
        if (!is_array($response)) {
            $response = json_decode($response, true);
        }
        if ($response['code'] !== 0) {
            throw new JeepayException($response['msg'], $response['code']);
        }
        $this->signature = $response['sign'];
        $this->msg = $response['msg'];
        $this->code = $response['code'];
        $this->data = $response['data'];
        $this->key = $key;
        $this->checkSign();
    }

    /**
     * 验证签名
     *
     * @throws JeepayException
     */
    private function checkSign(): void
    {
        if ($this->signature !== $this->sign($this->getData(), $this->key)) {
            throw new JeepayException('签名错误');
        }
    }

    /**
     * 获取响应数据
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * 获取消息
     *
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * 获取响应代码
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * 检查请求是否成功
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->code === '0';
    }

    /**
     * 动态访问响应数据
     *
     * @param string $name 数据字段
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * 检查数据字段是否存在
     *
     * @param string $name 数据字段
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * 将响应转为数组
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    // ArrayAccess 接口实现

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }
}