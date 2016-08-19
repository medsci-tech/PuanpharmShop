<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\MemberController;
use App\Models\Member\Member;
use App\Models\Member\MemberAddress;
use Illuminate\Http\Request;

/**
 * Class AddressController
 * @package App\Http\Controllers\Member
 */
class AddressController extends MemberController
{

    /**
     *
     */
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
     * Data filtering.
     *
     * @return array
     */
    private function formatData(Request $request)
    {
        $data = [
            'member_id' => $this->member->id,
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
        $addresses = MemberAddress::where('member_id', $this->member->id)->toArray();
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'addresses' => $addresses
                ]
            ]);
        } else {
            return view('member.address.index', [
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
        $addresses = MemberAddress::where('member_id', $this->member->id)->get()->toArray();
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'addresses' => $addresses
                ]
            ]);
        } else {
            return view('member.address.select', [
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
        return view('member.address.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payCreate()
    {
        return view('member.address.pay-create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCreate()
    {
        return view('member.address.select-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->formatData($request);
        $address = MemberAddress::create($data);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'address' => $address->getAttributes()
                ]
            ]);
        } else {
            return redirect('/member/address');
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
        MemberAddress::create($data);
        return redirect('/member/pay');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectStore(Request $request)
    {
        $data = $this->formatData($request);
        MemberAddress::create($data);
        return redirect('/member/select-address');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view('member.address.edit', ['address' => MemberAddress::find($request->input('id'))]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $this->formatData($request);
        $address = MemberAddress::find($request->input('id'));
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
            'success' => MemberAddress::destroy($request->input('id')) ? true : false
        ]);
    }

    /**
     * Pasa todas las direcciones a default 0.
     *
     */
    private function resetDefault()
    {
        MemberAddress::where('member_id', $this->member->id)->update(['default' => 0]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setDefault(Request $request)
    {
        $this->resetDefault();
        MemberAddress::where('member_id', $this->member->id)
            ->where('id', $request->get('address_id'))
            ->update(['default' => 1]);

        if ($request->header('referer') == url('/member/address')) {
            return redirect('/member/address');
        } else {
            return redirect('/member/pay');
        }
    }
}