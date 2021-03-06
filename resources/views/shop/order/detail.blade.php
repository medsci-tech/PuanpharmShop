<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>订单详情</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/rebuild.css') }}"/>
    <style>
        .shop-kuaidi100{
            display: inline-block;
            vertical-align: middle;
            margin: 0;
            font-size: 0.375rem;
            cursor: pointer;
            line-height: 1.5;
            -webkit-appearance: none;
            border-radius: 0.09375rem;
            border: 0.03125rem solid #e5e5e5;
            float: right;
            color: #fff;
            background-color: #3bb4f2;
            padding: 0.125rem 0.34rem;
            margin-top: .16rem;
            text-align: center;
            font-weight: bold;
        }
    </style>
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script><script type="text/javascript" src="/shop/js/libs/flexible.js"></script></head>
<body class="pay" style="background-color: #FAFAFA;font-size: 0.375rem;">
<main class="content">
    <div class="goods-list">
        <div class="header">
            <span class="shop"><strong>商品列表</strong></span>
        </div>
        <div class="goods">
            @foreach($order->products as $product)
                <div class="cart-item">
                    <div class="cart-info">
                        <a href="/shop/detail?id={{$product->id}}" class="preview">
                            <img src="{{$product->logo}}" alt="">
                        </a>

                        <div class="detail">
                            <a href="/shop/detail?id={{$product->id}}" class="goods-link">
                                <h3 class="goods-title">{{$product->name}}</h3>
                            </a>

                            <p class="goods-weight">{{isset($product->pivot->specification_id) ?\App\Models\ProductSpecification::find($product->pivot->specification_id)->specification_name : ''}}</p>
                        </div>
                        <div class="count">
                            <p class="price">
                                <span class="unit">&yen;</span>
                                <span class="value">{{isset($product->pivot->specification_id) ?\App\Models\ProductSpecification::find($product->pivot->specification_id)->specification_name : $product->price}}</span>
                            </p>

                            <div class="num">
                                <p class="value">{{$product->pivot->quantity}}</p>

                                <div class="quantity">
                                    <div class="btn minus disabled">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </div>
                                    <div class="btn plus">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="block-item price" style="border-top: 0.03125rem solid #e5e5e5;border-bottom: 0.03125rem solid #e5e5e5;">
        <p>商品合计<span class="num rmb">&yen;{{$order->products_fee}}</span></p>

        <p>邮费<span class="num rmb">&yen;{{$order->shipping_fee}}</span></p>
        @if($order->beans_fee)
        <p>迈豆抵扣<span class="num rmb" style="color: #3bb4f2">-&emsp;&yen;{{$order->beans_fee}}</span></p>
        @endif
        @if($order->cut_fee)
        <p>优惠券抵扣<span class="num rmb" style="color: #3bb4f2">-&emsp;&yen;{{$order->cut_fee}}</span></p>
        @endif
        <hr>
        <p>实际需付<span class="num rmb" style="color: #f60;font-weight: bold">&yen;{{$order->products_fee-$order->beans_fee+$order->shipping_fee}}</span></p>
    </div>

    <div class="order-express" style="border-top: 0.03125rem solid #e5e5e5;border-bottom: 0.03125rem solid #e5e5e5;">
        <div class="order-container">
            <div class="order-address order-item order-on">
                <div class="address-panel">
                    <div class="order-address-detail">
                        <div class="order-customer-info">
                            <span class="order-name">收&nbsp;&nbsp;货&nbsp;&nbsp;人：{{$order->address_name}}</span>
                        </div>
                        <div class="order-customer-info">
                            <span class="order-name">手&nbsp;&nbsp;机&nbsp;&nbsp;号：{{$order->address_phone}}</span>
                        </div>
                        <div class="order-customer-info">
                            <span class="order-name">收货地址：{{$order->address_province.$order->address_city.$order->address_district.$order->address_detail}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($order->shipping_no && $order->shipping_type)
        <div class="goods-list" style="border-top: 0.03125rem solid #e5e5e5;border-bottom: 0.03125rem solid #e5e5e5;">
            <div class="header">
                <span class="shop">快递单号<p style="float: right">{{$order->shipping_type}}:{{$order->shipping_no}}</p></span>
            </div>
            <div class="confirm" style="padding-bottom: 8px;" >
                <a class="next" href="http://m.kuaidi100.com/index_all.html?postid={{$order->shipping_no}}&callbackurl=http://puanpharm.ohmate.cn/shop/order">【查看物流】</a>
            </div>
        </div>
    @endif
</main>


<script type="text/javascript" src="/shop/js/components.js"></script>

<script type="text/javascript">
    $('#pay-weixin').on('click', function () {
        $.post('/shop/order/pay',
                $('#pay-form').serialize(),
                function (data) {
                    if (data.success) {
                        function onBridgeReady() {
                            WeixinJSBridge.invoke(
                                    'getBrandWCPayRequest', JSON.parse(data.data.result),
                                    function (res) {
                                        if (res.err_msg == "get_brand_wcpay_request:ok") {
                                            window.location.href = "/shop/pay-success";
                                        } // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
                                    }
                            );
                        }

                        if (typeof WeixinJSBridge == "undefined") {
                            if (document.addEventListener) {
                                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                            } else if (document.attachEvent) {
                                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                            }
                        } else {
                            onBridgeReady();
                        }

                    } else {
                        alert('服务器异常!');
                    }
                }, "json"
        );
    })
</script>
</body>
</html>
