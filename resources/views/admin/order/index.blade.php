@extends('.admin._layouts.common')
@section('title')
    订单列表
@stop
@section('main')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">商品管理</strong> /
                <small>订单列表</small>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">
                <a href="/admin/down-order-excel?date=today" type="button" class="am-btn am-btn-default">今日订单</a>
                <a href="/admin/down-order-excel?date=yesterday" type="button" class="am-btn am-btn-primary">昨日订单</a>
                <a href="/admin/down-order-excel?date=week" type="button" class="am-btn am-btn-secondary">最近7天订单</a>
                <a href="/admin/down-order-excel?date=month" type="button" class="am-btn am-btn-success">最近30天订单</a>
            </div>
            {{--<div class="am-u-sm-12 am-u-md-3">--}}
            {{--<select data-am-selected="{btnSize: 'sm'}" style="display: none;">--}}
            {{--<option value="option1">排序方式</option>--}}
            {{--<option value="option2">销量</option>--}}
            {{--<option value="option3">价格</option>--}}
            {{--<option value="option3">创建时间</option>--}}
            {{--</select>--}}
            {{--</div>--}}
        </div>
        <div class="am-g" style="margin-top: 15px">
            <div class="am-u-sm-12 am-u-md-6">
                <form action="/admin/order/search" method="post">
                    <div class="am-input-group am-input-group-sm">

                        <input type="text" name="keyword" class="am-form-field"
                               placeholder="订单ID、order_sn、收货人姓名、收货人电话、收获地址、总金额、客户ID">
                         <span class="am-input-group-btn">
                        <button class="am-btn am-btn-default" type="submit">搜索</button>
                       </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th>ID</th>
                            {{--<th>用户openid</th>--}}
                            <th>微信订单号</th>
                            {{--<th>订单号</th>--}}
                            <th class="table-title">供应商</th>
                            <th>商品</th>
                            <th>是否支付</th>
                            <th>商品总价</th>
                            <th>迈豆抵扣</th>
                            <th>收获地址</th>
                            <th>下单时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                {{--<td>{{$order->customer->openid}}</td>--}}
                                <td><a href="#">{{$order->out_trade_no}}</a></td>
                                {{--<td><a href="#">{{$order->order_sn}}</a></td>--}}
                                <td>{{$order->supplier->supplier_name}}</td>
                                <td>
                                    @foreach($order->products as $product)
                                        @if($product->pivot->specification_id)
                                            【{{$product->name.'('.\App\Models\ProductSpecification::find($product->pivot->specification_id)->specification_name.')x'.$product->pivot->quantity}}
                                            】
                                        @else
                                            【{{$product->name.'('.$product->default_spec.')x'.$product->pivot->quantity}}
                                            】
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$order->payment_status ?'已支付' : '未支付'}}</td>
                                <td>{{$order->products_fee}}</td>
                                <td>{{$order->beans_fee}}</td>
                                <td>
                                    收货地址：{{$order->address_province.$order->address_city.$order->address_district.$order->address_detail}}
                                    姓名：{{$order->address_name}}电话：{{$order->address_phone}}</td>
                                <td>{{$order->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
                            {{$orders->render() }}
                        </div>
                    </div>
                    <hr>
                </form>
            </div>
        </div>
    </div>
    <div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
        <div class="am-modal-dialog">
            <div class="am-modal-bd">
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-confirm>是</span>
                <span class="am-modal-btn" data-am-modal-cancel>否</span>
            </div>
        </div>
    </div>
    <script src="/admin/js/jquery.min.js"></script>
    <script type="text/javascript" language="javascript">
        window.onload = function () {
            paginations = document.getElementsByClassName('pagination');
            paginations[0].className = 'am-pagination';
            disabled = document.getElementsByClassName('disabled');
            if (disabled[0]) {
                disabled[0].className = 'am-disabled';
            }
            paginations = document.getElementsByClassName('active');
            paginations[0].className = 'am-active';
        }
    </script>
@stop
