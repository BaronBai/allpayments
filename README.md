# AllPayments
你没有看错，就是 “所有支付”，我会把所有能接的支付都接上来（优先接入我自己需要使用的）。  
*已经接入*
1. 微信官方  
    * 统一下单
2. 支付宝官方  
    * wap（手机网页支付）
3. 京东
    * 统一下单
4. 扫呗  
......

## Requirement
1. PHP >= 7.1
2. Composer 
3. openssl
4. 暂时没了

## Installation
`$ composer require mzt/all_payments:dev-master`

## Usage
基本使用(以微信为例子)  
```php
<?php  

use Mzt\AllPayments\Factory;

$wechatPay = Factory::wechatPay([
    'appid' => 'your app id',
    'mch_id' => 'your mch id',
    'key' => 'your key'
]); 

try{
    $result = $wechatPay->unified()->unify([
        'total_fee' => 1,
        'body' => '测试Wap支付',
        'out_trade_no' => 'sdk'.date('YmdHis'),
        'spbill_create_ip' => '127.0.0.1',
        'notify_url' => 'http://localhost',
        'trade_type' => 'JSAPI',
        'openid' => $_ENV['WECHAT_OPENID']
    ]);
    
    // ... 针对返回值做你的业务逻辑吧（所有类型的支付都是这个一个方法 unify）
}catch (\Mzt\AllPayments\Exceptions\PayException $e){
    
    // 如果抛出这个异常，一般来说都是微信方面给与的报错，那就是你给的参数有问题。
    
}catch (\Mzt\AllPayments\Exceptions\ValidatorException $e){
    
    // 如果抛出这个异常，那是说明对于微信支付来说必要的字段你可能没传。你得去看一下微信的文档了
}catch (\Mzt\AllPayments\Exceptions\ClientException $e){
    
    // 这里表示请求错了，比如说404,500什么的
}
```
## Documentation
https://www.kancloud.cn/maotao/all_payment_document/1269619

## 如何联系我
如果你在使用本SDK的过程中遇到了bug或者有任何建议，可以发邮件给我: mzt.live@live.com

## 写在最后
如果我做错了，请指出来，如果帮到你了，我很开心！

