<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>购物车</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>

<!--<header>-->
<!---->
<!--</header>-->

@if(count($products))
    <body class="cart">
    <!--<header>-->
    <!---->
    <!--</header>-->
    <main class="content">
        <!--
        <div class="tab cart">
            <a href="#" class="tab-btn current">购物车</a>
            <a href="#" class="tab-btn">购物记录</a>
            <a href="#" class="tab-btn">我的红包</a>
            <a href="#" class="tab-btn">我的返现</a>
        </div>
        -->
        <!--
        <div class="login-tip">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
            绑定手机号可保存购物车中所有商品
            <a href="#" class="btn login-btn">立即绑定</a>
        </div>
        -->
        <div class="shop-list">
            <div class="header">
                <a href="#" class="shop">购物车</a>
                <a class="edit">编辑</a>
            </div>
            <div class="cart-list">
                @foreach($products as $product)
                    <div class="cart-item"
                         id="product-{{sizeof($product->specification) ?$product->id.'-'.$product->specification->id : $product->id}}">
                        <div class="check-container">
                            <span class="check checked"></span>
                        </div>
                        <div class="cart-info">
                            <a href="/shop/detail?id={{$product->id}}" class="preview">
                                <img src="{{$product->logo}}" alt="">
                            </a>

                            <div class="detail">
                                <a href="/shop/detail?id={{$product->id}}" class="goods-link">
                                    <h3 class="goods-title">{{$product->name}}</h3>
                                </a>
                                @if($product->specification)
                                    <p class="goods-weight"> {{$product->specification->specification_name}}</p>
                                @else
                                    <p class="goods-weight"> {{$product->default_spec}}</p>
                                @endif
                            </div>
                            <div class="count">
                                <p class="price">
                                    <span class="unit">&yen;</span>
                                    <span class="value">@if($product->specification) {{$product->specification->specification_price}}@else{{$product->price}}@endif</span>
                                </p>

                                <div class="num">
                                    <p class="value">{{$product->quantity}}</p>

                                    <div class="quantity">
                                        <div class="btn minus disabled">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <input class="txt" type="text" value="1">

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
    </main>
    <nav class="footer">
        <div class="bottom-cart">
            <div class="select-all check-container">
                <span class="check checked"></span>
                <span class="label">全选</span>
            </div>
            <div class="total-price">
                合计：<span class="total-price-value"></span>元
            </div>
            <form action="/shop/pay" method="post">
                <!-- <button href="javascript:;" class="btn pay">结算(<span class="count">2</span>)</button> -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn pay" value="结算(2)">
            </form>
            <button href="javascript:;" class="btn delete">删除</button>
        </div>
    </nav>
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
                <h4>购物车里没有商品</h4>
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
    <script type="text/javascript" src="/shop/js/components.js"></script>
    <script type="text/javascript" src="/shop/js/main.js"></script>
    </body>
@endif
</html>
