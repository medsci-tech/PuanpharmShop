<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\WxController;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\Wx\WxMember;
use App\Models\Wx\WxMemberOrder;
use Illuminate\Http\Request;

class OrderController extends WxController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $productArray = $request->input('product');
        $productId = array_keys($productArray);
        $orderProducts = [];
        $productsFee = 0.0; //支付商品总价
        foreach ($productArray as $id => $quantity) {
            // products
            $array = explode('-', $id);
            $product = Product::find($array[0]);

            $productDetail['product_id'] = $product->id;
            $productDetail['quantity'] = $quantity;
            $productDetail['product'] = $product;

            if (sizeof($array) > 1) {
                $specification = ProductSpecification::find($array[1]);
                $productDetail['specification'] = $specification;
                $productsFee += $specification->specification_price * $quantity;
            } else {
                $productsFee += $product->price * $quantity;
            }
            // 拆分订单
            if (!array_key_exists($product->supplier_id, $orderProducts)) {
                $orderProducts[$product->supplier_id] = [];
            }
            array_push($orderProducts[$product->supplier_id], $productDetail);
        }

        $wxMember = $this->wxMember;
        // 创建订单
        $orderIds = array();
        $beansFee = $productsFee * 10;
        foreach ($orderProducts as $supplierID => $supplierProducts) {
            $orderData = [
                'supplier_id' => $supplierID,
                'wx_member_id' => $wxMember->id,
                'details' => $supplierProducts,
                'total_fee' => $beansFee,
                'shipping_fee' => 0,
                'beans_fee' => $beansFee,
                'order_sn' => time(),
                'address_phone' => $request->input('address_phone'),
                'address_name' => $request->input('address_name'),
                'address_province' => $request->input('address_province'),
                'address_city' => $request->input('address_city'),
                'address_district' => $request->input('address_district'),
                'address_detail' => $request->input('address_detail'),
            ];
            array_push($orderIds, WxMemberOrder::create($orderData)->id);
        }

        // 减糖豆
        $paid = \Helper::costBeansByPhone($this->wxMember->phone, $beansFee, 'wx');
        if ($paid) {
            WxMemberOrder::whereIn('id', $orderIds)->where('payment_status', 0)->update(['payment_status' => 1]);
            // 清除购物车
            \Redis::command('hdel', ['wx_id:' . $this->wxMember->id, $productId]);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        WxMemberOrder::destroy($request->input('order_id'));
        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $order = WxMemberOrder::find($request->input('order_id'));
        return view('shop.order.detail', [
            'order' => $order
        ]);
    }
}