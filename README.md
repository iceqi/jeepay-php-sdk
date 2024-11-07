# jeepay-php-sdk

#### 介绍
A jeepay SDK for php.

fork 自 reprover/jeepay-php-sdk 适配7.0

### 接口文档
接口文档：https://docs.jeequan.com/docs/jeepay/payment_api

### 快速开始
引入sdk依赖，支持：支付、退款、转账、分账等接口。


#### 安装教程
1.  composer require 1099438829/jeepay-php-sdk

### 使用教程

```php
//支付网关地址
$payHost = 'https://www.jeequan.com';
$mchNo = 'yourMchNo';
$appId = 'yourAppId';
$apiKey = 'yourApiKey';

$jeepayClient = new JeepayClient($payHost,$mchNo,$appId,$apiKey);
$params = [
    'amount' => 100,
    'currency' => 'CNY',
];

// 发送 GET 请求
try {
    $response = $jeepayClient->getContent($url, $params);
    print_r($response->getData());
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

// 发送 POST 请求
try {
    $postData = [
        'orderNo' => '123456',
        'amount' => 100,
    ];
    $response = $jeepayClient->postForm($url, $postData);
    print_r($response->getData());
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

```


#### 参与贡献

1.  Fork 本仓库
2.  新建 Feat_xxx 分支
3.  提交代码
4.  新建 Pull Request


