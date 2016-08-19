<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->customerID = \Session::get(\Config::get('constants.SESSION_USER_KEY'))->id;
        $this->openID = \Session::get(\Config::get('constants.SESSION_USER_KEY'))->openid;
    }

    /**
     * @var array
     */
    private $formRules = [
        'name' => 'required|max:100',
        'product_id' => 'required',
        'description' => 'required',
        'price' => 'required',
    ];

    /**
     * @var
     */
    protected $customerID;

    /**
     * @var
     */
    protected $openID;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $customer = Customer::find($this->customerID);
        $orders = $customer->ordersWithProducts()->get();
        return view('shop.order.index', [
            'orders' => $orders
        ]);
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
                //$productDetail['product_price'] = $specification->specification_price;
                $productsFee += $specification->specification_price * $quantity;
            } else {
                //$productDetail['product_price'] = $product->price;;
                $productsFee += $product->price * $quantity;
            }
            // 拆分订单
            if (!array_key_exists($product->supplier_id, $orderProducts)) {
                $orderProducts[$product->supplier_id] = [];
            }
            array_push($orderProducts[$product->supplier_id], $productDetail);
        }

        // 计算价格
        $shippingFee = 8.0;
        $beansFee = 0.0;

        $customer = Customer::find($this->customerID);
        if ($customer->unionid) {
            $data = \Helper::getBeansByUnionid($customer->unionid);
            if ($data) {
                if (($data / 100) > $productsFee) {
                    $beansFee = $productsFee;
                } else {
                    $beansFee = $data / 100;
                    $beansFee = sprintf("%.2f", substr(sprintf("%.3f", $beansFee), 0, -2));
                }
            }
        }
        $totalFee = $productsFee + $shippingFee;
        $payFee = $totalFee - $beansFee;
//        if ($productsFee >= 99.0) {
//            $totalFee = $productsFee;
//            $payFee = $totalFee - $beansFee;
//        } else {
//            $totalFee = $productsFee + $shippingFee;
//            $payFee = $totalFee - $beansFee;
//        }

        // 创建订单
        $outTradeNo = time();
        foreach ($orderProducts as $supplierID => $supplierProducts) {
            $orderData = [
                'supplier_id' => $supplierID,
                'customer_id' => $this->customerID,
                'details' => $supplierProducts,
                'total_fee' => $totalFee,
                'shipping_fee' => $shippingFee,
                'beans_fee' => $beansFee,
                'order_sn' => time(),
                'address_phone' => $request->input('address_phone'),
                'address_name' => $request->input('address_name'),
                'address_province' => $request->input('address_province'),
                'address_city' => $request->input('address_city'),
                'address_district' => $request->input('address_district'),
                'address_detail' => $request->input('address_detail'),
            ];
            $outTradeNo .= '-' . Order::create($orderData)->id;
        }
        $paymentConfig = [
            'body' => '普安易康',
            'out_trade_no' => $outTradeNo,
            'total_fee' => '' . floor(strval($payFee * 100)),
            'notify_url' => url('/wechat/payment/notify'),
            'openid' => $this->openID
        ];
        // 清除购物车
        \Redis::command('hdel', ['user_id:' . $this->customerID, $productId]);

        $result = \Wechat::generatePaymentConfig($paymentConfig);

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $result,
                'out_trade_no' => $outTradeNo,
            ]
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        $array = explode("-", $order->out_trade_no);
        $outTradeNo = time() . '-' . implode('-', $array);

        $paymentConfig = [
            'body' => '普安易康',
            'out_trade_no' => $outTradeNo,
            'total_fee' => '' . floor(strval($order->pay_fee * 100)),
            'notify_url' => url('/wechat/payment/notify'),
            'openid' => $this->openID
        ];
        $result = \Wechat::generatePaymentConfig($paymentConfig);
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $result['paymentConfig'],
                'unifiedOrder' => $result['unifiedOrder'],
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        Order::destroy($request->input('order_id'));
        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        return view('shop.order.detail', [
            'order' => $order
        ]);
    }
}