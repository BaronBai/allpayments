<?php
/**
 * Created by PhpStorm.
 * User: pro4
 * Date: 2019/9/8
 * Time: 15:35
 */

namespace Mzt\Tests\AliPay;

use Mzt\AllPayments\PayService\WapPay\WapPayByAli;
use Mzt\AllPayments\Utils\Signs\RSA2Sign;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WapPayByAliTest extends TestCase
{


    /**
     * @var WapPayByAli $wapPay
    */
    protected $wapPay;

    protected function setUp()
    {
        parent::setUp();
        $wapPay = new WapPayByAli(
            new RSA2Sign()
        );

        $wapPay->setConfig([
            "app_id" => "2016101100664216",
            "private_key" => "MIIEowIBAAKCAQEAvXhMnZABxkmYPpClkMcMJiLZhYfYs33vUupW3oj7ljg5IkzIvt+swew6Z1hiRuUykj8qz+QEqh4aFb9G8bCTQpGbYhuRAUEL/iCC7ahwV+J/AcXN/CjMp67yLZ9XUgyag0gmyhZU8HN0FviXHPfRXoERpATHTG3jidODfhjPJuDFdilWB3Ikc4Yp5dYmrCpXtiJv5Ukfye/TXLxNXhifUDEw0ZrmrNHmENyw9Vj3AYdfWmdmVAS4TPj8oKY2bH0Ntrs1Zf36J5JHK69pTtMGlyDrXvbZgHymx+HwqfAUdmPConOf7tJQNLxQ4xwyx/InAL3mWCw/mFVQY4i22eF4ZQIDAQABAoIBAE1lXc6jK8Zm+7Ta+3bniFPvunFsa53unJt/NFsVE8hqURRszzgBQJ26tKTQmtyg9YZ+HSvs1eb0Au3NQ9qoqY7w0ctCvXoIqzB08WbJfpK35+++cIVH2UnKEg2G4HGYymlESOwWMT5DuzFC/N+Nb84t5RneBdd3sBH1/+m7kqsrQ1yz1lhqNlZG6NpLi3Z06ZTZp2a0sNlnbb8Qtr5hN1nTWygyspofyFN8ij3qbhjCWImpbbIP2Rv21Ik9rqBDp7vXgxv7Yvx8NHXd5NIYExULtdbzJXjyShtUnGzK5ZhugkkRa/r4yYUO/XPJ0C+HbHzBhpeqFT30E98tn199gMUCgYEA8lypDTIrE88xcOJvAP3xz7XoQ28vtRy/0P2DVVkvO+LgRdRVXJZ3BGpGEnAtw9WAT+2xphztVery0ZB3iCWj/0YtW+RAt3OmzhKtgBHcf5x2VwZgQJzU2mmdXt4n9QUPWMOuNiX8915pk4fzE7gVfbXDf5GM+uI8DGoAuhy44FMCgYEAyCG0MwcrerSYNGNIfeoeBf1/6UVqT5W1b0GkHCBp/4ksuUSl7qO+ZR1WfE0HqkqTaFGBNegloYRTXytH11k76hjab9XipBlWuj805Gi91Dl+l7mSeMIS7W4CtGsU73RZu6m9Zjk0n7njhZu79vQE+h04lWkpGEh/s52QJgAZDWcCgYBkpbZOlJbvEwwlJOOUNeFFsPVTi8j0HYxK7fysZO0IoZ8hYJxSZunmG3weDBf1S6SNjNhJc5ncJEXSYXxCPd9tE2ei0ZdOl+idi4Qhu0kmdYNvgGZYbsi2K0X/L6LITeGhqyGduwjicYLGkZ6QgdHq8qDNSVSSm4D0ZtEGeQcNoQKBgBfJEa6i4oMB5bkMN7hnU8wodcRWsKzmwRqI9aU2IQLy3bLjOsljAqTn2LiLOyb9GAnk7fNnNNm+bV45OZ+ZhmprK8Lw66/PJySZkIK5BB6t+qKztnnNrwwy7/VbaLCQ5n1MTitRDzUQlb7yZGOUWucTA/+V8QFm1G6XgmNRzahvAoGBAJ8fncIRZj0IjC9ZEgTkorA47EaghkJwVcaCBh0SpFaKMZSLtZGGL57sFI9zb36Px8p55o1661QGal3ZNe8pRGqdQnWXgyp7AIM6LGlUOzKT2+Bm5yry2WSYOcrj5YtkDWimegFn488snoMJTikUJ6KufoV3MzuBnB+RuN9bexYZ",
            "ali_public_key" => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkq26l9yO+q6m0GkLamQpgpwYVIGsb0nPsDBVZfsELcjmPO8315SvqT+cPs6AR1/etQbfc+EBChyTKlw9o6VuhGQpaQGbKmOAsEyUfMwwrkhwK5hFa9n7rXAh6q0+15ubQx09xcVyX+boezgkNXrGsXKvUBTro7AgT/P3oM5nNQfEaLFgNRttgIsSXQ5IOTum/UhmzBHiWcPaFgyllLXavS+TMnGgJgmJflvRivy9QkSquEwE+aIKiafE7hsaJVIg5/2vXMOw6oZbtB2zLOd27wShnz9JjUq5v512ylOnTBuuJCC9hdWrTHKP9HxGKF56nZWW/bnMyhPSs7+D0hGY2wIDAQAB"
        ]);

        $this->wapPay = $wapPay;
    }

    public function testResponse(){

        $result = $this->wapPay->wapPay([
            "notify_url" => "http://locahost",
            "biz_content" => [
                "subject" => "测试商品",
                "out_trade_no" => "sdk".date("YmdHis"),
                "total_amount" => 1
            ]
        ]);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}