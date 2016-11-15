<?php

namespace App\Http\Controllers;
use App\Http\Requests;

class TestController extends Controller
{
    function items()
    {
        $data = [
            "method" => "gy.erp.items.get",
            "page_no" => "1",
            "page_size" => "100",
        ];

        dd(\Erp::post($data));
    }

    function orders()
    {
        $data = [
            "method" => "gy.erp.trade.get",
            "page_no" => "1",
            "page_size" => "100",
        ];

        dd(\Erp::post($data));
    }


    function suppliers()
    {
        $data = [
            "method" => "gy.erp.supplier.get",
            "page_no" => "1",
            "page_size" => "100",
        ];

        dd(\Erp::post($data));
    }

    function vip()
    {
        $data = [
            "method" => "gy.erp.vip.get",
            "page_no" => "1",
            "page_size" => "100",
        ];

        dd(\Erp::post($data));
    }

    function shop()
    {
        $data = [
            "method" => "gy.erp.shop.get",
            "page_no" => "1",
            "page_size" => "100",
        ];

        dd(\Erp::post($data));
    }

    function warehouse()
    {
        $data = [
            "method" => "gy.erp.warehouse.get",
            "page_no" => "1",
            "page_size" => "100",
        ];

        dd(\Erp::post($data));
    }

    function test()
    {
        $data = [
            "method" => "gy.erp.trade.add",
            "details" => [
                [
                    "qty" => 11,
                    "item_code" => "4117",
                    "price" => 11,
                    "note" =>null,
                    "refund" => 0,
                    "oid" =>null,
                    "sku_code" =>null,
                ]
            ],
            "payments" => [
                [
                    "payment" => 100,
                    "paytime" => "2016-09-08 09:54:22",
                    "account" =>null,
                    "pay_type_code" => "1012014021233754645",
                    "pay_code" =>null
                ]
            ],
            "invoices" => [
                [
                    "invoice_type" => 1,
                    "invoice_title" =>null,
                    "invoice_content" =>null,
                    "invoice_amount" =>null,
                    "bill_amount" =>null
                ]
            ],
            "shop_code" => "易康伴侣",
            "vip_code" => "18986109549",
            "warehouse_code" => "易康伴侣",
            "deal_datetime" => "2016-09-08 15:03:45",
            "express_code" => "ZJS"
        ];

//        $data = [
//            "method" => "gy.erp.trade.add",
//            "format" =>null,
//            "code" =>null,
//            "qty" => 0,
//            "amount" => 0,
//            "payment" => 0,
//            "cod" => false,
//            "refund" => 0,
//            "pay_datetime" => "2014-12-16 18:00:00",
//            "tagId" =>null,
//            "msg" =>null,
//            "shop_code" => "易康伴侣",
//            "platform_code" =>null,
//            "vip_code" => "wangzgtest",
//            "vip_name" => "wangzgtest",
//            "unpaid_amount" => 0,
//            "post_fee" => 0,
//            "cod_fee" => 0,
//            "discount_fee" => 0,
//            "warehouse_code" => "A001",
//            "express_code" => "ZJS",
//            "plan_delivery_date" =>null,
//            "business_man_code" =>null,
//            "buyer_memo" =>null,
//            "seller_memo" =>null,
//            "receiver_name" =>null,
//            "receiver_province" =>null,
//            "receiver_city" =>null,
//            "receiver_district" =>null,
//            "receiver_phone" => "11111",
//            "receiver_mobile" => "11111",
//            "receiver_zip" =>null,
//            "receiver_address" =>null,
//            "area_id" =>null,
//            "create_name" =>null,
//            "unique_tid" =>null,
//            "seller_memo_late" =>null,
//            "deal_datetime" => "2014-12-16 18:00:00",
//            "order_type_code" =>null,
//            "order_settlement_code" =>null,
//            "invoice_title" =>null,
//            "platform_flag" => 0,
//            "tag_code" =>null,
//            "human_express" => false,
//            "hold_info" =>null,
//            "vipIdCard" =>null,
//            "vipRealName" =>null,
//            "vipEmail" =>null,
//            "details" => [
//                [
//                    "qty" => 0,
//                    "price" => 0,
//                    "note" =>null,
//                    "refund" => 0,
//                    "oid" =>null,
//                    "item_code" =>null,
//                    "sku_code" =>null,
//
//                ]
//            ],
//            "payments" => [
//                [
//                    "payment" => 100,
//                    "paytime" => "2014-12-17 09:54:22",
//                    "account" =>null,
//                    "pay_type_code" => "1012014021233754645",
//                    "pay_code" =>null
//                ]
//            ],
//            "invoices" => [
//                [
//                    "invoice_type" => 1,
//                    "invoice_title" =>null,
//                    "invoice_content" =>null,
//                    "invoice_amount" =>null,
//                    "bill_amount" =>null
//                ]
//            ]
//        ];

        dd(\Erp::postOrder($data));
    }

    function sendMessage() {
        dd(\Message::createMessage('15827388360', '测试'));
    }

    function ems() {
       \EMS::updatePrintData(1);
    }

    function demo()
    {
        dd(\Erp::addTrade());
    }
}
