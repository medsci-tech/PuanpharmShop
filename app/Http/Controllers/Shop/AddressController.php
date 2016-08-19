<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->customerID = \Session::get(\Config::get('constants.SESSION_USER_KEY'))->id;
    }

    private $formRules = [
        'name' => 'required|max:100',
        'product_id' => 'required',
        'description' => 'required',
        'price' => 'required',
    ];

    protected $customerID;

    /**
     * Data filtering.
     *
     * @return array
     */
    private function formatData(Request $request)
    {
        $data = [
            'customer_id' => $this->customerID,
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'province' => $request->input('province'),
            'city' => $request->input('city'),
            'district' => $request->input('district'),
            'address' => $request->input('address'),
        ];
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $addresses = Address::where('customer_id', $this->customerID)->get()->toArray();
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'addresses' => $addresses
                ]
            ]);
        } else {
            return view('shop.address.index', [
                'addresses' => $addresses
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectAddress(Request $request)
    {
        $addresses = Address::where('customer_id', $this->customerID)->get()->toArray();
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'addresses' => $addresses
                ]
            ]);
        } else {
            return view('shop.address.select', [
                'addresses' => $addresses

            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shop.address.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payCreate()
    {
        return view('shop.address.pay-create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCreate()
    {
        return view('shop.address.select-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->formatData($request);
        $address = Address::create($data);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'address' => $address->getAttributes()
                ]
            ]);
        } else {
            return redirect('/shop/address');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function payStore(Request $request)
    {
        $data = $this->formatData($request);
        Address::create($data);
        return redirect('/shop/pay');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectStore(Request $request)
    {
        $data = $this->formatData($request);
        Address::create($data);
        return redirect('/shop/select-address');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view('shop.address.edit', ['address' => Address::find($request->input('id'))]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //$this->validate($request, $this->formRules);
        $data = $this->formatData($request);
        $address = Address::find($request->input('id'));
        $address->update($data);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'address' => $address->getAttributes()
                ]
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => [
                    'address' => $address->getAttributes()
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return response()->json([
            'success' => Address::destroy($request->input('id')) ? true : false
        ]);
    }

    /**
     * Pasa todas las direcciones a default 0.
     *
     */
    private function resetDefault()
    {
        Address::where('customer_id', $this->customerID)->update(['default' => 0]);
    }


    public function setDefault(Request $request)
    {
        $this->resetDefault();
        Address::where('customer_id', $this->customerID)
            ->where('id', $request->get('address_id'))
            ->update(['default' => 1]);

        //if(strrchr($request->header('referer'), "/") == '/address') {
        if ($request->header('referer') == url('/shop/address')) {
            return redirect('/shop/address');
        } else {
            return redirect('/shop/pay');
        }
    }
}