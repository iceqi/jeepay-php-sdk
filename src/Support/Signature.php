<?php

namespace Muzi\Jeepay\Support;

trait Signature
{

    public function checkSign(array $data, string $key): bool
    {
        $sign = $data['sign'];
        unset($data['sign']);
        return $sign === $this->sign($data, $key);
    }

    public function sign(array $data, string $key)
    {
        ksort($data);
        reset($data);
        $md5str = "";
        foreach ($data as $k => $val) {
            if (strlen($k) && strlen($val)) {
                $md5str .= $k . "=" . $val . "&";
            }
        }
        $sign = strtoupper(md5($md5str . "key=" . $key));
        return $sign;
    }

    private function toUrlParams($data): string
    {
        $buff = "";
        foreach ($data as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }

        return rtrim($buff, "&");
    }
}