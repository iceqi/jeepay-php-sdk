<?php

declare(strict_types=1);

namespace Muzi\Jeepay\Support;

class Config
{
    private $key;
    private $baseURL;
    private $mchNo;
    private $appId;

    public function __construct(string $key, string $baseURL, string $mchNo, string $appId)
    {
        $this->key = $key;
        $this->baseURL = $baseURL;
        $this->mchNo = $mchNo;
        $this->appId = $appId;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getBaseURL(): string
    {
        return $this->baseURL;
    }

    public function getMchNo(): string
    {
        return $this->mchNo;
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function getAttribute(): array
    {
        return [
            'key' => $this->key,
            'baseURL' => $this->baseURL,
            'mchNo' => $this->mchNo,
            'appId' => $this->appId,
        ];
    }
}
