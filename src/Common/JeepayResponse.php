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
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @throws \Muzi\Jeepay\Exceptions\JeepayException
     */
    private function checkSign(): void
    {
        if ($this->signature !== $this->sign($this->getData(), $this->key)) {
            throw new JeepayException('签名错误');
        }
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    public function isSuccess(): bool
    {
        return $this->code === '0';
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function toArray(): array
    {
        return $this->data;
    }

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
