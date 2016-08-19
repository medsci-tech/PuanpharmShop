<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>订单列表</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>

@if(count($orders))
    <body class="order" style="background-color: #FAFAFA;">
    <main class="content">
        <div class="goods-list">
            @foreach($orders as $order)
                @if($order->payment_status)
                    <div class="order-item" data-order_id="{{$order->id}}"
                         style="border-top: 0.03125rem solid #e5e5e5;border-bottom: 0.03125rem solid #e5e5e5;">
                        <div class="header">
                            <span class="shop">订单号：{{$order->order_sn}}</span>
                            <!--<a class="edit">编辑</a>-->
                        <span class="status">
                            @if($order->payment_status)
                                <strong style="color: #009900">已付款</strong>
                            @else
                                <strong>待付款</strong>
                            @endif

                        </span>
                        </div>
                        <div class="goods orderDetail">
                            @foreach($order->products as $product)
                                <div class="cart-item">
                                    <div class="cart-info">
                                        <a href="/shop/order/detail?order_id={{$order->id}}" class="preview">
                                            <img src="{{$product->logo}}" alt="">
                                        </a>

                                        <div class="detail">
                                            <a href="/shop/order/detail?order_id={{$order->id}}" class="goods-link">
                                                <h3 class="goods-title">{{$product->name}}</h3>
                                            </a>

                                            <p class="goods-weight">{{isset($product->pivot->specification_id) ?\App\Models\ProductSpecification::find($product->pivot->specification_id)->specification_name : $product->default_spec}}</p>
                                        </div>
                                        <div class="count">
                                            <p class="price">
                                                <span class="unit">&yen;</span>
                                                <span class="value">{{isset($product->pivot->specification_id) ?\App\Models\ProductSpecification::find($product->pivot->specification_id)->specification_name : $product->price}}</span>
                                            </p>

                                            <div class="num">
                                                <p class="value">{{$product->pivot->quantity}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="block-item total" style="font-size: 0.375rem;">
                            下单时间：{{$order->created_at}}

                            <span style="float: right"><strong
                                        style="color: #007aff">&yen;{{$order->products_fee}}</strong></span>
                            {{--<div class="btn-group">--}}

                            {{--<span class="btn cancel">取消</span>--}}
                            {{--<a href="/shop/index" class="btn pay">付款</a>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </main>
    <div class="mask-layer">

    </div>
    <div class="notify">
        <p class="notify-inner"></p>
    </div>
    <script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
    <script type="text/javascript" src="/shop/js/components.js"></script>
    <script type="text/javascript" src="/shop/js/main.js"></script>
    </body>
@else
    <body class="empty">
    <main class="content">
        <div class="empty-list " style="padding-top:60px;">
            <!-- 文本 -->
            <div class="empty-list-header">
                <h4>你还没有订单</h4>
                <span>快给我挑点宝贝</span>
            </div>
            <!-- 自定义html，和上面的可以并存 -->
            <div class="empty-list-content">
                <a href="/shop/index" class="empty-btn">去逛逛</a>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
    <script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/libs/jquery.pep.js"></script>
    <script type="text/javascript" src="/shop/js/main.js"></script>
    </body>
@endif
</html>
