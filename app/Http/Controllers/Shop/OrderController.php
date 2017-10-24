<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;

/**
 * Class OrderController
 * @package App\Http\Controllers\Shop
 */
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
        $orders = $customer->ordersWithProducts()->orderBy('created_at', 'desc')->get();
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
        $productTaxFee = 0.0; //进口税商品总价
        $productsFee = 0.0; //支付商品总价
        $product_fee_without_sale = 0.0;
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
                if ($product->on_sale == 0) {
                    $product_fee_without_sale += $specification->specification_price * $quantity;
                }
            } else {
                //$productDetail['product_price'] = $product->price;;
                $productsFee += $product->price * $quantity;
                if ($product->on_sale == 0) {
                    $product_fee_without_sale += $product->price * $quantity;
                }
            }
            if($product->is_abroad==1) // 海淘商品
            {
                $productTaxFee += $product->price_tax * $quantity; // 进口税总价
            }
            // 拆分订单
            if (!array_key_exists($product->supplier_id, $orderProducts)) {
                $orderProducts[$product->supplier_id] = [];
            }
            array_push($orderProducts[$product->supplier_id], $productDetail);
        }

        // 计算价格
        $shippingFee = 8.0;
        if (\Session::get('baby_shop', 0) != 0) {
            $shippingFee = 0.0;
        }
        $beansFee = 0.0;

        $customer = Customer::find($this->customerID);
        if ($customer->unionid) {
            $customerBeans = \Helper::getBeansByUnionid($customer->unionid);
            if ($customerBeans) {
                if (($customerBeans / 100) > $productsFee+$productTaxFee) {
                    $beansFee = $productsFee+$productTaxFee;
                } else {
                    $beansFee = $customerBeans / 100;
                    $beansFee = sprintf("%.2f", substr(sprintf("%.3f", $beansFee), 0, -2));
                }
            }
        }
        $totalFee = $productsFee + $shippingFee + $productTaxFee;
        $payFee = $totalFee - $beansFee;

        $cut_fee = 0.00;
        if ($coupon_id = $request->input('coupon', null)) {

            $coupon = Coupon::find($coupon_id);
            if (!$coupon || $coupon->customer_id != $customer->id) {
                return response('Wrong coupon!', 500);
            }

            if ($product_fee_without_sale < $coupon->couponType->price_required) {
                return response('Not enough price to use this coupon!', 500);
            }

            if ($product_id_required = $coupon->couponType->product_id_required) {
                if (!$this->productsArrayContainsProduct($productArray, $product_id_required)) {
                    return response('Does not have necessary product!', 500);
                }
            }

            if (($coupon_cut_price = $coupon->couponType->cut_price) > 0) {
                $cut_fee = $coupon_cut_price;
            } elseif ((($cut_percentage = $coupon->couponType->cut_percentage) > 0)  && ($cut_percentage < 1)) {
                $cut_fee = $product_fee_without_sale * $cut_percentage;
            }

            if ($payFee >= $cut_fee) {
                $payFee -= $cut_fee;
            } else {
                $payFee = 0;
            }

        }

//        包邮
//        if ($productsFee >= 99.0) {

//            $totalFee = $productsFee;
//            $payFee = $totalFee - $beansFee;
//        } else {
//            $totalFee = $productsFee + $shippingFee;
//            $payFee = $totalFee - $beansFee;
//        }

        // 创建订单
        $outTradeNo = time();
//        $orders_count = count($orderProducts);
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
                'idCard' => $request->input('address_idCard'),
                'coupon_id' => $coupon_id? $coupon_id: null,
                'tax_fee' => $productTaxFee,
                'pay_fee' => $payFee,
                'cut_fee' =>$cut_fee
            ];
            $order = Order::create($orderData);
            $outTradeNo .= '-' . $order->id;

        }

        if($this->customerID == 1028) {
            $paymentConfig = [
                'body' => '普安易康',
                'out_trade_no' => $outTradeNo,
                'total_fee' => '' . 1,
                'notify_url' => url('/wechat/payment/notify'),
                'openid' => $this->openID
            ];
        } else {
            $paymentConfig = [
                'body' => '普安易康',
                'out_trade_no' => $outTradeNo,
                'total_fee' => '' . floor(strval($payFee * 100)),
                'notify_url' => url('/wechat/payment/notify'),
                'openid' => $this->openID
            ];
        }

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

    private function productsArrayContainsProduct($productID, $product_id_required)
    {
        foreach ($productID as $k => $v) {
            $array = explode('-', $k);
            $product_id = $array[0];
            if ($product_id == $product_id_required) {
                return true;
            }
        }

        return false;
    }
}