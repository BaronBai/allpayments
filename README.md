# AllPayments
你没有看错，就是 “所有支付”，我会努力尽早把所有能接的支付都接上来。

## Requirement
1. PHP >= 7.1
2. Composer 
3. 暂时没了

## Installation
`$ composer require mzt/all_payments`

## Usage
基本使用(以微信为例子)  
```php
<?php  

use Mzt\AllPayments\Factory;

$wechatPay = Factory::wechat([
    'appid' => 'your app id',
    'mch_id' => 'your mch id',
    'key' => 'your key'
]); 

try{
    $result = $wechatPay->unifiedOrder()->unify([
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
}
```
## Documentation
这个嘛，我暂时还没写好，等我写好就弄上来。（包上传日期 2019年9月5日）

## 写在最后
第一次想做一个完整的包，也是第一次努力的去写，希望大家能给予帮助，指出我的错误。  
同时、也希望这个包能帮助到大家。