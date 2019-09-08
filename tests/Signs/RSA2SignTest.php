<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/6
 * Time: 17:45
 */

namespace Mzt\Tests\Signs;


use Mzt\AllPayments\Utils\Signs\RSA2Sign;
use PHPUnit\Framework\TestCase;

class RSA2SignTest extends TestCase
{
    protected $sign = "hF8Xe8GWu1me00fyGdhwFzeJ4V7dqzCE7jvNCtHNamQxepcfIFl1/bYLfSRUac+hy+2xlv03gNhQIGoqW1l3nSWsOqC1ofNiND4tCAoohSSvilxjEIFj7sJ0n8QTJ6s/5OA9ep34GMyJlvlmOd3T2EIjjx7hdaOiYULHIxYg/8C/LkeXggm7jb+p4sGE5f8a/W/H67AlA6D7raKsN4XW9NhK8/WmdWAjk8xyDU2AEsT4bEtgXG79+g3p1SX5idRxf2mIllqN1bVVwlQJYWlGxe9BPo9IYCHAN1klhAEVTPHirEVkxzAr7qe8mSznq3krqkvzlOU/pDVOiWyiZ/FNaQ==";
    protected $privateKey = "MIIEowIBAAKCAQEAvXhMnZABxkmYPpClkMcMJiLZhYfYs33vUupW3oj7ljg5IkzIvt+swew6Z1hiRuUykj8qz+QEqh4aFb9G8bCTQpGbYhuRAUEL/iCC7ahwV+J/AcXN/CjMp67yLZ9XUgyag0gmyhZU8HN0FviXHPfRXoERpATHTG3jidODfhjPJuDFdilWB3Ikc4Yp5dYmrCpXtiJv5Ukfye/TXLxNXhifUDEw0ZrmrNHmENyw9Vj3AYdfWmdmVAS4TPj8oKY2bH0Ntrs1Zf36J5JHK69pTtMGlyDrXvbZgHymx+HwqfAUdmPConOf7tJQNLxQ4xwyx/InAL3mWCw/mFVQY4i22eF4ZQIDAQABAoIBAE1lXc6jK8Zm+7Ta+3bniFPvunFsa53unJt/NFsVE8hqURRszzgBQJ26tKTQmtyg9YZ+HSvs1eb0Au3NQ9qoqY7w0ctCvXoIqzB08WbJfpK35+++cIVH2UnKEg2G4HGYymlESOwWMT5DuzFC/N+Nb84t5RneBdd3sBH1/+m7kqsrQ1yz1lhqNlZG6NpLi3Z06ZTZp2a0sNlnbb8Qtr5hN1nTWygyspofyFN8ij3qbhjCWImpbbIP2Rv21Ik9rqBDp7vXgxv7Yvx8NHXd5NIYExULtdbzJXjyShtUnGzK5ZhugkkRa/r4yYUO/XPJ0C+HbHzBhpeqFT30E98tn199gMUCgYEA8lypDTIrE88xcOJvAP3xz7XoQ28vtRy/0P2DVVkvO+LgRdRVXJZ3BGpGEnAtw9WAT+2xphztVery0ZB3iCWj/0YtW+RAt3OmzhKtgBHcf5x2VwZgQJzU2mmdXt4n9QUPWMOuNiX8915pk4fzE7gVfbXDf5GM+uI8DGoAuhy44FMCgYEAyCG0MwcrerSYNGNIfeoeBf1/6UVqT5W1b0GkHCBp/4ksuUSl7qO+ZR1WfE0HqkqTaFGBNegloYRTXytH11k76hjab9XipBlWuj805Gi91Dl+l7mSeMIS7W4CtGsU73RZu6m9Zjk0n7njhZu79vQE+h04lWkpGEh/s52QJgAZDWcCgYBkpbZOlJbvEwwlJOOUNeFFsPVTi8j0HYxK7fysZO0IoZ8hYJxSZunmG3weDBf1S6SNjNhJc5ncJEXSYXxCPd9tE2ei0ZdOl+idi4Qhu0kmdYNvgGZYbsi2K0X/L6LITeGhqyGduwjicYLGkZ6QgdHq8qDNSVSSm4D0ZtEGeQcNoQKBgBfJEa6i4oMB5bkMN7hnU8wodcRWsKzmwRqI9aU2IQLy3bLjOsljAqTn2LiLOyb9GAnk7fNnNNm+bV45OZ+ZhmprK8Lw66/PJySZkIK5BB6t+qKztnnNrwwy7/VbaLCQ5n1MTitRDzUQlb7yZGOUWucTA/+V8QFm1G6XgmNRzahvAoGBAJ8fncIRZj0IjC9ZEgTkorA47EaghkJwVcaCBh0SpFaKMZSLtZGGL57sFI9zb36Px8p55o1661QGal3ZNe8pRGqdQnWXgyp7AIM6LGlUOzKT2+Bm5yry2WSYOcrj5YtkDWimegFn488snoMJTikUJ6KufoV3MzuBnB+RuN9bexYZ";



    public function testSign(){

        $params = [
            "app_id" => "2016101100664216",
            "method" => "alipay.trade.wap.pay",
            "sign_type" => "RSA2",
            "charset" => "utf-8",
            "timestamp" => "2019-09-06 17:11:47",
            "version" => "1.0",
            "notify_url" => "https://localhost/adfl",
            "biz_content" => [
                "subject" => "测试商品",
                "out_trade_no" => "sdk20190908072645",
                "total_amount" => 1.00,
                "product_code" => "QUICK_WAP_WAY"
            ]
        ];

        $params['biz_content'] = json_encode($params['biz_content']);
        $util = new RSA2Sign();
        $sign = $util->sign($params,$this->privateKey);
        $this->assertEquals($sign,$this->sign);
    }


    public function testSignWithKeyFile(){

        $params = [
            "app_id" => "2016101100664216",
            "method" => "alipay.trade.wap.pay",
            "sign_type" => "RSA2",
            "charset" => "utf-8",
            "timestamp" => "2019-09-06 17:11:47",
            "version" => "1.0",
            "notify_url" => "https://localhost/adfl",
            "biz_content" => [
                "subject" => "测试商品",
                "out_trade_no" => "sdk20190908072645",
                "total_amount" => 1.00,
                "product_code" => "QUICK_WAP_WAY"
            ]
        ];

        $params['biz_content'] = json_encode($params['biz_content']);

        $file = TEMP_DIR.'/keys/ras2.private.txt';
        $util = new RSA2Sign();
        $sign = $util->sign($params,$file);
        $this->assertEquals($sign,$this->sign);
    }


    public function testVerifySign(){
        $params = [
            "body" => "大乐透2.1",
            "buyer_id" => "2088102116773037",
            "charset" => "utf-8",
            "gmt_close" => "2016-07-19 14:10:46",
            "gmt_payment" => "2016-07-19 14:10:47",
            "notify_time" => "2016-07-19 14:10:49",
            "notify_type" => "trade_status_sync",
            "out_trade_no" => "0719141034-6418",
            "refund_fee" => 0.00,
            "subject" => "大乐透2.1",
            "total_amount" => 2.00,
            "trade_no" => "2016071921001003030200089909",
            "trade_status" => "TRADE_SUCCESS",
            "version" => "1.0"
        ];

        $query = urldecode(http_build_query($params));

    }
}