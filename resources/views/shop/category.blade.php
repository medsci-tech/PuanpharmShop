<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{$category->name}}</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>
<body class="index">
<main class="content">
    <div class="products products-wrapper">
        @foreach($category->products as $product)
            <a class="product" id="product-{{$product->id}}" href="/shop/detail?id={{$product->id}}">
                <div class="product-pic">
                    <img src="{{$product->logo}}" alt="">
                </div>
                <div class="product-info">
                    <p class="product-name">{{$product->name}}</p>

                    <p class="product-price">
                        <span class="price">&yen;{{$product->price}}</span>
                        /
                        <span class="other">{{$product->beans}}迈豆</span>
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</main>

<nav class="footer">
    <a href="/shop/index" class="home fa fa-home" aria-hidden="true"></a>

    <div class="menus">
        <div class="menu">
            <a href="/shop/hot-category" class="menu-name fa fa-pause-circle">商品分类</a>
        </div>
        <div class="menu">
            <span class="menu-name fa fa-pause-circle">特惠专区</span>

            <div class="sub-menu">
                <ul>
                    @foreach($activities as $activity)
                        <li class="sub-menu-item">
                            <a href="/shop/activity?activity_id={{$activity->id}}">{{$activity->activity_name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="menu">
            <a href="/shop/personal" class="menu-name fa fa-pause-circle">个人中心</a>
        </div>
    </div>
</nav>

<div class="mask-layer">

</div>

<div class="window buy">
    <div class="window-title">
        <div class="preview">
            <img src="http://placeholder.qiniudn.com/100x100" alt="">
        </div>
        <div class="detail">
            <h3 class="title"></h3>

            <p class="price">
                <span class="unit">&yen;</span>
                <span class="value">/span>
            </p>
        </div>
        <div class="close">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
        </div>
    </div>
    <div class="window-frame">
        <div class="view">
            <div class="item-info">
                <p class="info-title">规格（粒/袋/ml/g）：</p>
            </div>
            <div class="specific">
                <span class="tag active">300g</span>
                <span class="tag">500g</span>
                <span class="tag">1000g</span>
            </div>
            <form action="/shop/pay" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="product_id" value="" class="added-product-id">

                <div class="buy">
                    <div class="quantum">
                        <span>购买数量：</span>

                        <div class="quantity">
                            <div class="btn minus disabled">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </div>
                            <input class="txt" type="text" name="quantity" value="1">

                            <div class="btn plus">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    {{--<div class="other-info">--}}
                    {{--<p class="quota">每人限购1件</p>--}}
                    {{--</div>--}}
                </div>
                <div class="confirm">
                    <input type="submit" class="btn buy-now" value="立即购买">
                    <a class="btn add-cart" style="float: right">加入购物车</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="global-cart">
    <a href="/shop/cart">
        @if($cartCount)
            <span class="title-num">{{$cartCount}}</span>
        @endif
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    </a>
</div>
<div class="notify">
    <p class="notify-inner">添加购物车成功</p>
</div>
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="/shop/js/libs/jquery.pep.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
</body>
</html>
