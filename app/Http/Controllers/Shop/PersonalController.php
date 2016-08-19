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
        return view('shop.personal.index', [
            'customer' => Customer::find($this->customerID),
            'activities' => Activity::all()
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
        $end = new \DateTime(Carbon::now()->format('Y-m'));
        $begin = new \DateTime($customer->created_at->format('Y-m'));
        $months = $this->getMonthPeriod($begin, $end);
        $monthsBeans = [];
        foreach ($months as $month) {
            $monthsBeans[$month] = $customer->monthBeans($month);
        }
        return view('shop.personal.beans', [
            'monthsBeans' => $monthsBeans,
            'now' => Carbon::now()->format('Y-m')
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