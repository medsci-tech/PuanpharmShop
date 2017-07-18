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
                <a href="/admin/order-2-excel" type="button" class="am-btn am-btn-default">全部订单</a>
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
            <div class="am-u-sm-12 am-text-nowrap am-scrollable-horizontal">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-compact am-table-hover table-main">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>微信订单号</th>
                            <th class="table-title">供应商</th>
                            <th>商品</th>
                            <th>备注</th>
                            <th>是否支付</th>
                            <th>订单总价(拆单前)</th>
                            <th>邮费</th>
                            <th>税费</th>
                            <th>优惠券抵扣</th>
                            <th>实际支付</th>
                            <th>商品总价（拆单后）</th>
                            <th>收货地址</th>
                            <th>下单时间</th>
                            <th>订单号</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td><a href="#">{{$order->out_trade_no}}</a></td>
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
                                <td>
                                    @if($order->remark)
                                        {{$order->remark}}
                                    @else
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a type="button" class="am-btn am-btn-success"
                                                   id="set-remark{{ $order->id }}">添加备注</a>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>{{$order->payment_status ?'已支付' : '未支付'}}</td>
                                <td>{{$order->total_fee}}</td>
                                <td>{{$order->shipping_fee}}</td>
                                <td>{{$order->tax_fee}}</td>
                                <td>{{$order->cut_fee}}</td>
                                <td>{{$order->pay_fee}}</td>
                                <td>{{$order->products_fee}}</td>
                                <td>
                                    收货地址：{{$order->address_province.$order->address_city.$order->address_district.$order->address_detail}}
                                    姓名：{{$order->address_name}}电话：{{$order->address_phone}} @if($order->idCard)身份证：{{$order->idCard}}@endif</td>
                                <td>{{$order->created_at}}</td>
                                <td>
                                    @if($order->shipping_no)
                                        {{'【'.$order->shipping_type.'】'.$order->shipping_no}}
                                    @else
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a type="button" class="am-btn am-btn-success"
                                                   id="set-num{{ $order->id }}">填写单号</a>
                                            </div>
                                        </div>
                                    @endif
                                </td>
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
                <select name="shipping_type" id="shipping_type">
                    <option value="圆通">圆通</option>
                    <option value="顺丰">顺丰</option>
                    <option value="顺丰">中通</option>
                </select>
                <input type="text" id="shipping_no" placeholder="在此填写单号"><br>
                <input type="checkbox" id="send_message">
                <label for="send_message">给顾客发送短信提醒</label>
                <span class="am-modal-btn" data-am-modal-confirm>确认</span>
                <span class="am-modal-btn" data-am-modal-cancel>关闭</span>
            </div>
        </div>
    </div>

    <div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm-2">
        <div class="am-modal-dialog">
            <div class="am-modal-bd-2">
            </div>
            <div class="am-modal-footer">
                <input type="text" placeholder="在此填写备注" id="remark">
                <span class="am-modal-btn" data-am-modal-confirm>确认</span>
                <span class="am-modal-btn" data-am-modal-cancel>关闭</span>
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
        };

        $(function () {
            $('[id^=set-num]').on('click', function () {
                $('.am-modal-bd').text('请填写订单号');
                id = this.id.slice(7);
                $('#my-confirm').modal({
                    relatedTarget: this,
                    onConfirm: function (options) {

                        var shippingNo = $('#shipping_no').val();
                        var shippingType = $('#shipping_type').val();
                        var sendMessage = $('#send_message').get(0).checked;
                        $.ajax({
                            url: '/admin/order/set-ems-num',
                            type: 'get',
                            dataType: 'text',
                            data: {
                                shipping_no: shippingNo,
                                shipping_type: shippingType,
                                send_message: sendMessage,
                                order_id: id
                            },
                            contentType: 'application/json',
                            async: true,
                            success: function (data) {
                                location.reload();
                            },
                            error: function (XMLResponse) {
                                alert(XMLResponse.responseText);
                            }
                        });
                    },
                    onCancel: function () {
                    }
                });
            });
        });

        $(function () {
            $('[id^=set-remark]').on('click', function () {
                $('.am-modal-bd-2').text('请填写备注');
                id = this.id.slice(10);
                $('#my-confirm-2').modal({
                    relatedTarget: this,
                    onConfirm: function (options) {

                        var remark = $('#remark').val();
                        $.ajax({
                            url: '/admin/order/set-remark',
                            type: 'get',
                            dataType: 'text',
                            data: {
                                remark: remark,
                                order_id: id
                            },
                            contentType: 'application/json',
                            async: true,
                            success: function (data) {
                                location.reload();
                            },
                            error: function (XMLResponse) {
                                alert(XMLResponse.responseText);
                            }
                        });
                    },
                    onCancel: function () {
                    }
                });
            });
        });
    </script>
@stop
