<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\ProductSpecification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Product;
use App\Models\Address;
use Overtrue\Wechat\Js;

/**
 * Class ShopController
 * @package App\Http\Controllers\Shop
 */
class ShopController extends Controller
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
     * @var int
     */
    protected $customerID;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fromUrl = Input::get('fromUrl');
        \Session::put('baby', 0);
        \Session::put('baby_shop', 0);

        $js = new Js(env('WX_APPID'), env('WX_SECRET'));


        $categories = array_chunk(Category::where('is_banner', 1)->get()->toArray(), 8);
        return view('shop.index', [
            'products' => Product::where('supplier_id', 1)->whereIn('display_setting', ['普安商城', '普安商城和奶粉商城'])->orderBy('weight', 'desc')->get(),
            'catArrays' => $categories,
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID])),
            'banners' => Banner::where('baby', 0)->orderBy('weight', 'desc')->get(),
            'baby_banners' => Banner::where('baby', 1)->orderBy('weight', 'desc')->get(),
            'fromUrl' => $fromUrl,
            'js' => $js
        ]);
    }

    public function babyIndex()
    {
        $fromUrl = Input::get('fromUrl');
        \Session::put('baby', 1);
        $baby_shop = Input::get('baby-shop', 0);
        if ($baby_shop == 1) {
            \Session::put('baby_shop', 1);
        } elseif ($baby_shop == 2) {
            \Session::put('baby_shop', 2);
        } elseif ($baby_shop == 3) {
            \Session::put('baby_shop', 3);
        } else {
            \Session::put('baby_shop', 0);
        }

        $js = new Js(env('WX_APPID'), env('WX_SECRET'));


        $categories = array_chunk(Category::where('is_baby_banner', 1)->get()->toArray(), 8);
        return view('shop.index', [
            'products' => Product::whereIn('display_setting', ['奶粉商城', '普安商城和奶粉商城'])->orderBy('weight', 'desc')->get(),
            'catArrays' => $categories,
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID])),
            'banners' => Banner::where('baby', 1)->orderBy('weight', 'desc')->get(),
            'fromUrl' => $fromUrl,
            'js' => $js
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        if (\Redis::command('HEXISTS', ['search', $keyword])) {
            \Redis::command('HINCRBY', ['search', $keyword, 1]);
        } else {
            \Redis::command('hset', ['search', $keyword, 1]);
        }
        $products = Product::search($keyword)->where('is_show', 1)->orderBy('weight', 'desc')->get();
        return view('shop.search', [
            'products' => $products,
            'keyword' => $keyword,
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID]))
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request)
    {
        return view('shop.category', [
            'category' => Category::find($request->input('category_id')),
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID]))
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activity(Request $request)
    {
        return view('shop.activity', [
            'activity' => Activity::find($request->input('activity_id')),
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID]))
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hotCategory()
    {
        return view('shop.hot-category', [
            'catArrays' => array_chunk(Category::where('status', 1)->get()->toArray(), 3),
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID]))
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productList()
    {
        return response()->json(Product::orderBy('weight', 'desc')->paginate('6'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productSpecifications(Request $request)
    {
        $specs = ProductSpecification::where('product_id', $request->input('product_id'))->get();
        if ($specs) {
            $html = '<div class="item-info"><p class="info-title">规格（粒/袋/ml/g）：</p></div>';
            $html .= '<div class="specific">';
            foreach ($specs as &$spec) {
                $html .= '<span class="tag" data-spec_price="' . $spec->specification_price . '">' . $spec->specification_name . '</span>';
            }
            $html .= '</div>';
            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $js = new Js(env('WX_APPID'), env('WX_SECRET'));

        $baby = Input::get('baby', 0);
        $baby_shop = Input::get('baby-shop', 0);
        if ($baby == 1) {
            \Session::put('baby', 1);
        } else {
//            \Session::put('baby', 0);
        }
        if ($baby_shop == 1) {
            \Session::put('baby_shop', 1);
        } elseif ($baby_shop == 2) {
            \Session::put('baby_shop', 2);
        } elseif ($baby_shop == 3) {
            \Session::put('baby_shop', 3);
        } else {
//            \Session::put('baby_shop', 0);
        }

        $share_link = $request->fullUrl();
        if (\Session::get('baby', 0) == 1) {
            if (\Session::get('baby_shop', 0) == 1) {
                $share_link = $request->fullUrl(). '&baby=1&baby-shop=1';
            } elseif (\Session::get('baby_shop', 0) == 2) {
                $share_link = $request->fullUrl(). '&baby=1&baby-shop=2';
            } elseif (\Session::get('baby_shop', 0) == 3) {
                $share_link = $request->fullUrl(). '&baby=1&baby-shop=3';
            }
        }

        return view('shop.detail', [
            'product' => Product::find($request->input('id')),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID])),
            'js' => $js,
            'share_link' => $share_link
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pay(Request $request)
    {
        // address
        $address = Address::where('default', 1)->where('customer_id', $this->customerID)->first();
        if (!$address) {
            $address = Address::where('customer_id', $this->customerID)->first();
        }

        // products
        if ($request->has('product_id')) {
            $productID = $request->input('product_id');
            if ($request->has('spec_id')) {
                foreach ($productID as $key => $value) {
                    $productID = [
                        $key . '-' . $request->input('spec_id') => $value
                    ];
                }
            }
            \Session::set('pay_product_id', $productID);
        } else {
            $productID = \Session::get('pay_product_id');;
        }
        $is_abroad = []; // 是否海淘标识
        $productTaxFee = 0; // 海淘税费用

        $products = [];
        $productFee = 0;
        $product_fee_without_sale = 0;
        foreach ($productID as $id => $quantity) {
            $array = explode('-', $id);
            $product = Product::find($array[0]);
            $product->quantity = $quantity;
            if (sizeof($array) > 1) {
                $product->specification = ProductSpecification::find($array[1]);
                $productFee += $product->specification->specification_price * $product->quantity;
                if ($product->on_sale == 0) {
                    $product_fee_without_sale += $product->specification->specification_price * $product->quantity;
                }
            } else {
                $productFee += $product->price * $product->quantity;
                if ($product->on_sale == 0) {
                    $product_fee_without_sale += $product->price * $product->quantity;
                }
            }
            if($product->is_abroad==1) //  海淘商品
            {
                array_push($is_abroad, 1);
                $productTaxFee += $product->price_tax * $product->quantity;  // 海淘税
            }
            array_push($products, $product);
        }
        $abroad= array_sum($is_abroad)>=1 ? 1 : 0; // 是否包含海淘

        $beansFee = 0.0;
        $customer = Customer::find($this->customerID);
        if ($customer->unionid) {
            $data = \Helper::getBeansByUnionid($customer->unionid);
            if ($data) {
                if (($data / 100) > $productFee+$productTaxFee) {
                    $beansFee = $productFee+$productTaxFee;
                } else {
                    $beansFee = $data / 100;
                    $beansFee = sprintf("%.2f", substr(sprintf("%.3f", $beansFee), 0, -2));
                }

            }
        }

        $coupon_list = [];
        $unusable_coupon_list = [];

        foreach ($customer->coupons()->where('used', 0)->where('expire_at', '>', Carbon::now())->get() as $coupon) {
            if ($product_fee_without_sale < $coupon->couponType->price_required) {
                $unusable_coupon_list []= $coupon;
                continue;
            }

            if ($product_id_required = $coupon->couponType->product_id_required) {
                if (!$this->productsArrayContainsProduct($productID, $product_id_required)) {
                    $unusable_coupon_list []= $coupon;
                    continue;
                }
            }

            $coupon_list []= $coupon;
        }

        $shipping_fee = 8.0;
        if (\Session::get('baby_shop', 0) != 0) {
            $shipping_fee = 0.0;
        }

        return view('shop.pay', [
            'products' => $products,
            'address' => $address,
            'productFee' => $productFee,
            'product_fee_without_sale' => $product_fee_without_sale,
            'beansFee' => $beansFee,
            'is_abroad' => $abroad,
            'coupons' => $coupon_list,
            'unusable_coupons' => $unusable_coupon_list,
            'productTaxFee' => $productTaxFee,
            'shipping_fee' => $shipping_fee
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function paySuccess()
    {
        return view('shop/pay-success');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function test()
    {
        $paymentConfig = [
            'body' => '普安易康',
            'out_trade_no' => time() . '-123',
            'total_fee' => '' . floor(strval(1 * 100)),
            'notify_url' => url('/wechat/payment/notify'),
            'openid' => $this->openID
        ];
        $result = \Wechat::testGeneratePaymentConfig($paymentConfig);
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
    function getCodeUrl(Request $request)
    {
        $outTradeNo = $request->input('out_trade_no');
        $idArray = explode("-", $outTradeNo);
        array_shift($idArray);
        $orders = Order::whereIn('id', $idArray)->get();
        $productsFee = 0.0;
        $shippingFee = 8.0;
        $beansFee = 0.0;
        foreach ($orders as $order) {
            $productsFee += $order->products_fee;
        }
        $productsFee = $productsFee + $shippingFee;
        $payFee = $productsFee - $beansFee;
        $paymentConfig = [
            'body' => '普安易康',
            'out_trade_no' => time() . '-' . implode('-', $idArray),
            'total_fee' => '' . floor(strval($payFee * 100)),
            //'total_fee' => '' . floor(strval(1)),
            'notify_url' => url('/wechat/payment/notify'),
            'openid' => $this->openID
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'codeUrl' => \Wechat::getCodeUrl($paymentConfig)
            ]
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