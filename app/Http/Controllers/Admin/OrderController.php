<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductSpecification;
use App\Models\Supplier;
use Carbon\Carbon;
use \Excel;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        return view('admin.order.index', ['orders' => Order::where('payment_status', 1)->orderBy('created_at', 'desc')->paginate('20')]);
    }


    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        return view('admin.order.index', ['orders' => Order::search($keyword)->where('payment_status', 1)->paginate('20')]);
    }

    public function downOrderExcel(Request $request)
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
                    $order = Order::where('supplier_id', $supplier->id)->where('created_at', '>', $date)->where('payment_status', 1)->get();
                    $sheet->fromArray(
                        $this->formatForExcel($order)
                    );
                });
            }

        })->download('xls');

        return redirect()->back();
    }

    public function order2Excel()
    {
        \Excel::create('全部订单', function ($excel) {
            $suppliers = Supplier::all();
            foreach ($suppliers as $supplier) {
                $excel->sheet($supplier->supplier_name, function ($sheet) use ($supplier) {
                    $order = Order::where('supplier_id', $supplier->id)->where('payment_status', 1)->get();
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setEMSNum(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        if ($order->ems_num) {
            return response()->json([
                'success' => false,
                'data' => [
                    'error_message' => '已分配订单号'
                ]
            ]);
        } else {
            $EMSNum = \EMS::getBillNum();
            return response()->json([
                'success' => Order::find($request->input('order_id'))->update(['ems_num' => $EMSNum])
            ]);
        }
    }

    public function printEMSOrder(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        if($order->supplier_id == 1) {
            \Message::createMessage($order->address_phone, '顾客您好！您在易康商城的订单['.$order->order_sn.'-'.$order->id.']已经为您发货，EMS发货单号为'.$order->ems_num.'，感谢您的惠顾！');
            return view('admin.EMS.oct', [
                'order' => $order
            ]);
        } else {
            dd('非易康自营，不可打印');
        }
    }

    public function printData(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        //head|businessType|billnoType|Billno|dateType|procdate|scontactor|scustMobile|scustTelplus|scustPost|scustAddr|tcontactor|tcustMobile|tcustTelplus|tcustPost|tcustAddr|tcustProvince|tcustCity|tcustCounty|weight|insure|fee|feeUppercase|cargoDesc|bigAccountDataId|customerDn|mainBillNo|blank1|blank2|end
        $prtData = 'head|4|2|{{$order->ems_num}}|2|' . date('Y-m-d H:i:s') . '|易康伴侣|联系方式:4001199802|4001199502|430000|湖北省武汉市高新大道666号光谷生物城C2-4|' . $order->address_name . '|' . $order->address_phone . '||邮编|' . $order->address_detail . '|' . $order->address_province . '|' . $order->address_city . '|' . $order->address_district . '|1||||';
        foreach ($order->products as $product) {
            $prtData .= '【' . $product->name . '(';
            if ($product->pivot->specification_id) {
                $prtData .= ProductSpecification::find($product->pivot->specification_id)->specification_name;
            } else {
                $prtData .= $product->default_spec;
            }
            $prtData .= ')x' . $product->pivot->quantity . '】';
        }
        $prtData .= '|' . $order->order_sn . '|' . $order->order_sn . '||||end';

        return response()->json([
            'success' => false,
            'data' => [
                'prtData' => $prtData

            ]
        ]);
    }
}
