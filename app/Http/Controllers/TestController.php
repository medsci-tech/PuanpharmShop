<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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

    }

    function sendMessage() {
        dd(\Message::createMessage('15827388360', '测试'));
    }

    function ems() {
       \EMS::updatePrintData(1);
    }

    function demo(Request $request)
    {
        dd(\Erp::addTrade($request->input('id')));
    }
}
