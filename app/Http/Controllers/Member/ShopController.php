<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\MemberController;
use App\Models\Activity;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Member\Member;
use App\Models\Member\MemberAddress;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use App\Models\Product;
use Symfony\Component\Console\Helper\Helper;

/**
 * Class ShopController
 * @package App\Http\Controllers\Member
 */
class ShopController extends MemberController
{

    public function __construct()
    {

        parent::__construct();
        $this->member = Member::where('phone', $this->phone)->first();
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
        return view('member.index', [
            'products' => Product::where('category_id', 106)->orderBy('weight', 'desc')->get(),
            'catArrays' => $categories,
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['phone:' . $this->phone])),
            'banners' => Banner::orderBy('weight', 'desc')->get()
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
        return view('member.search', [
            'products' => $products,
            'keyword' => $keyword,
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['phone:' . $this->phone]))
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request)
    {
        return view('member.category', [
            'category' => Category::find($request->input('category_id')),
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['phone:' . $this->phone]))
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activity(Request $request)
    {
        return view('member.activity', [
            'activity' => Activity::find($request->input('activity_id')),
            'activities' => Activity::all(),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['phone:' . $this->phone]))
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hotCategory()
    {
        return view('member.hot-category', [
            'catArrays' => array_chunk(Category::all()->toArray(), 3),
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
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        return view('member.detail', [
            'product' => Product::find($request->input('id')),
            'cartCount' => sizeof(\Redis::command('HKEYS', ['phone:' . $this->phone]))
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pay(Request $request)
    {
        // address
        $address = MemberAddress::where('default', 1)->where('member_id', $this->member->id)->first();
        if (!$address) {
            $address = MemberAddress::where('member_id', $this->member->id)->first();
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

        return view('member.pay', [
            'products' => $products,
            'address' => $address,
            'productFee' => $productFee,
            'beans' => \Helper::getBeansByPhone($this->phone)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function paySuccess()
    {
        return view('/member/pay-success');
    }
}