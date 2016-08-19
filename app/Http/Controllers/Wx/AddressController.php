<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\WxController;
use App\Models\Wx\WxMember;
use App\Models\Wx\WxMemberAddress;
use Illuminate\Http\Request;

/**
 * Class AddressController
 * @package App\Http\Controllers\Member
 */
class AddressController extends WxController
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Data filtering.
     *
     * @return array
     */
    private function formatData(Request $request)
    {
        $data = [
            'wx_member_id' => $this->wxMember->id,
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
        $addresses = WxMemberAddress::where('wx_member_id', $this->wxMember->id)->get()->toArray();
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'addresses' => $addresses
                ]
            ]);
        } else {
            return view('wx.address.index', [
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
        $addresses = WxMemberAddress::where('wx_member_id', $this->wxMember->id)->get()->toArray();
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'addresses' => $addresses
                ]
            ]);
        } else {
            return view('wx.address.select', [
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
        return view('wx.address.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payCreate()
    {
        return view('wx.address.pay-create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCreate()
    {
        return view('wx.address.select-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->formatData($request);
        $address = WxMemberAddress::create($data);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'address' => $address->getAttributes()
                ]
            ]);
        } else {
            return redirect('/wx/address');
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
        WxMemberAddress::create($data);
        return redirect('/wx/pay');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectStore(Request $request)
    {
        $data = $this->formatData($request);
        WxMemberAddress::create($data);
        return redirect('/wx/select-address');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view('wx.address.edit', ['address' => WxMemberAddress::find($request->input('id'))]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $this->formatData($request);
        $address = WxMemberAddress::find($request->input('id'));
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
            'success' => WxMemberAddress::destroy($request->input('id')) ? true : false
        ]);
    }

    /**
     * Pasa todas las direcciones a default 0.
     *
     */
    private function resetDefault()
    {
        WxMemberAddress::where('wx_member_id', $this->wxMember->id)->update(['default' => 0]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setDefault(Request $request)
    {
        $this->resetDefault();
        WxMemberAddress::where('wx_member_id', $this->wxMember->id)
            ->where('id', $request->get('address_id'))
            ->update(['default' => 1]);

        if ($request->header('referer') == url('/wx/address')) {
            return redirect('/wx/address');
        } else {
            return redirect('/wx/pay');
        }
    }
}