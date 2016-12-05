<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Product;
use App\Models\Address;

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
        $categories = array_chunk(Category::where('is_banner', 1)->get()->toArray(), 8);
        return view('shop.index', [
            'products' => Product::where('supplier_id', 1)->orderBy('weight', 'desc')->get(),
            'catArrays' => $categories,
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID])),
            'banners' => Banner::orderBy('weight', 'desc')->get(),
            'fromUrl' => $fromUrl
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
            'activities' => Activity::all()
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
        return view('shop.detail', [
            'product' => Product::find($request->input('id')),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['user_id:' . $this->customerID]))
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

        $products = [];
        $productFee = 0;
        foreach ($productID as $id => $quantity) {
            $array = explode('-', $id);
            $product = Product::find($array[0]);
            $product->quantity = $quantity;
            if (sizeof($array) > 1) {
                $product->specification = ProductSpecification::find($array[1]);
                $productFee += $product->specification->specification_price * $product->quantity;
            } else {
                $productFee += $product->price * $product->quantity;
            }
            array_push($products, $product);
        }

        $beansFee = 0.0;
        $customer = Customer::find($this->customerID);
        if ($customer->unionid) {
            $data = \Helper::getBeansByUnionid($customer->unionid);
            /* 同步查询用户通行证验证 */
            $res = \Helper::tocurl(env('API_URL'). '/query-user-information?phone='.$customer->phone, $post_data=array(),0);
            //$data  = $res['result']['bean']['number'] ? $res['result']['bean']['number'] : 0;

            if ($data) {
                if (($data / 100) > $productFee) {
                    $beansFee = $productFee;
                } else {
                    $beansFee = $data / 100;
                    $beansFee = sprintf("%.2f", substr(sprintf("%.3f", $beansFee), 0, -2));
                }
            }
        }
        return view('shop.pay', [
            'products' => $products,
            'address' => $address,
            'productFee' => $productFee,
            'beansFee' => $beansFee,
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
}