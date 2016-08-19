<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\WxController;
use App\Models\Activity;
use App\Models\Banner;
use App\Models\Category;
use App\Models\ProductSpecification;
use App\Models\Wx\WxMember;
use App\Models\Wx\WxMemberAddress;
use Illuminate\Http\Request;
use App\Models\Product;

/**
 * Class ShopController
 * @package App\Http\Controllers\Wx
 */
class ShopController extends WxController
{

    public function __construct()
    {

        parent::__construct();
        $this->member = WxMember::where('phone', $this->wxMember->phone)->first();
    }

    /**
     * @var mixed
     */
    protected $member;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = array_chunk(Category::where('is_banner', 1)->get()->toArray(), 8);
        return view('wx.index', [
            'products' => Product::where('category_id', 106)->orderBy('weight', 'desc')->get(),
            'catArrays' => $categories,
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['wx_id:' . $this->wxMember->id])),
            'banners' => Banner::orderBy('weight', 'desc')->get()
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
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        return view('wx.detail', [
            'product' => Product::find($request->input('id')),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['wx_id:' . $this->wxMember->id]))
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pay(Request $request)
    {
        // address
        $address = WxMemberAddress::where('default', 1)->where('wx_member_id', $this->wxMember->id)->first();
        if (!$address) {
            $address = WxMemberAddress::where('wx_member_id', $this->wxMember->id)->first();
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

        return view('wx.pay', [
            'products' => $products,
            'address' => $address,
            'productFee' => $productFee,
            'beans' => \Helper::getBeansByPhone($this->wxMember->phone)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function paySuccess()
    {
        return view('/wx/pay-success');
    }
}