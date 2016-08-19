<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\MemberOrder;
use App\Models\ProductSpecification;
use App\Models\Supplier;
use App\Models\Wx\WxMemberOrder;
use Carbon\Carbon;
use \Excel;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function wx()
    {
        return view('admin.member.wx-order', ['orders' => WxMemberOrder::where('payment_status', 1)->paginate('20')]);
    }

    public function member()
    {
        return view('admin.member.member-order', ['orders' => MemberOrder::where('payment_status', 1)->paginate('20')]);
    }


    public function wxSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        return view('admin.member.wx-order', ['orders' => WxMemberOrder::search($keyword)->where('payment_status', 1)->paginate('20')]);
    }

    public function memberSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        return view('admin.member.member-order', ['orders' => MemberOrder::search($keyword)->where('payment_status', 1)->paginate('20')]);
    }

    public function wxDownOrderExcel(Request $request)
    {
        $date = $request->input('date');

        switch ($date) {
            case 'today':
                $date = Carbon::now()->format('Y-m-d');
                break;
            case 'yesterday':
                $date = Carbon::yesterday()->format('Y-m-d');
                break;
            case 'week':
                $date = Carbon::now()->subWeek()->format('Y-m-d');
                break;
            case 'month':
                $date = Carbon::now()->subMonth()->format('Y-m-d');
                break;
            default:
                $date = Carbon::now()->format('Y-m-d');
        }
        \Excel::create('订单列表_' . $date . '至' . date('Y-m-d'), function ($excel) use ($date) {
            $suppliers = Supplier::all();
            foreach ($suppliers as $supplier) {
                $excel->sheet($supplier->supplier_name, function ($sheet) use ($supplier, $date) {
                    $order = wxMemberOrder::where('supplier_id', $supplier->id)->where('created_at', '>', $date)->get();
                    $sheet->fromArray(
                        $this->formatForExcel($order)
                    );
                });
            }

        })->download('xls');

        return redirect()->back();
    }

    public function memberDownOrderExcel(Request $request)
    {
        $date = $request->input('date');

        switch ($date) {
            case 'today':
                $date = Carbon::now()->format('Y-m-d');
                break;
            case 'yesterday':
                $date = Carbon::yesterday()->format('Y-m-d');
                break;
            case 'week':
                $date = Carbon::now()->subWeek()->format('Y-m-d');
                break;
            case 'month':
                $date = Carbon::now()->subMonth()->format('Y-m-d');
                break;
            default:
                $date = Carbon::now()->format('Y-m-d');
        }
        \Excel::create('订单列表_' . $date . '至' . date('Y-m-d'), function ($excel) use ($date) {
            $suppliers = Supplier::all();
            foreach ($suppliers as $supplier) {
                $excel->sheet($supplier->supplier_name, function ($sheet) use ($supplier, $date) {
                    $order = MemberOrder::where('supplier_id', $supplier->id)->where('created_at', '>', $date)->get();
                    $sheet->fromArray(
                        $this->formatForExcel($order)
                    );
                });
            }

        })->download('xls');

        return redirect()->back();
    }

    public function formatForExcel($orders)
    {
        foreach ($orders as &$order) {
            $productsInfo = '';
            foreach ($order->products as $product) {
                if ($product->pivot->specification_id) {
                    $productsInfo = '【商品名字：' . $product->name . '|规格' . ProductSpecification::find($product->pivot->specification_id)->specification_name . '| 数量：' . $product->pivot->quantity . '】';
                } else {
                    $productsInfo = '【商品名字：' . $product->name . '|规格' . $product->default_spec . '| 数量：' . $product->pivot->quantity . '】';
                }
            }
            $order->productsInfo = $productsInfo;
        }
        return $orders->toArray();
    }
}
