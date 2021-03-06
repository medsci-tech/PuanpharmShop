<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Customer;
use Carbon\Carbon;


class PersonalController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->customerID = \Session::get(\Config::get('constants.SESSION_USER_KEY'))->id;
    }

    /**
     * @var
     */
    protected $customerID;


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $customer =  Customer::find($this->customerID);
        return view('shop.personal.index', [
            'customer' => $customer,
            'activities' => Activity::all(),
            'beans' => \Helper::getBeansByUnionid($customer->unionid),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function promote()
    {
        return view('shop.promote');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function beans()
    {
        $customer = Customer::find($this->customerID);
        if ($customer->unionid) {
            $logs = \Helper::getBeansLogByUnionid($customer->unionid);
            if($logs) {
                $begin = new \DateTime(date ('Y-m', strtotime(current($logs)->created_at)));
            } else {
                $begin = new \DateTime($customer->created_at->format('Y-m'));
            }

        } else {
            $begin = new \DateTime($customer->created_at->format('Y-m'));
            $logs = false;
        }

        $end = new \DateTime(Carbon::now()->format('Y-m'));

        return view('shop.personal.beans', [
            'logs' => $logs,
            'now' => Carbon::now()->format('Y-m'),
            'months' => $this->getMonthPeriod($begin, $end),
        ]);
    }

    /**
     * @param \DateTime $begin
     * @param \DateTime $end
     * @return array
     */
    function getMonthPeriod($begin, $end)
    {
        $end = $end->modify('+1 day');
        $interval = new \DateInterval('P1M');
        $daterange = new \DatePeriod($begin, $interval, $end);
        $months = [];
        foreach ($daterange as $date) {
            array_push($months, $date->format('Y-m'));
        }
        return $months;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function aboutUS()
    {
        return view('shop.personal.about-us');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function rule()
    {
        return view('shop.personal.rule');
    }
}