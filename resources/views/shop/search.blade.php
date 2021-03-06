<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商城</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/rebuild.css') }}"/>
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script><script type="text/javascript" src="/shop/js/libs/flexible.js"></script></head>
<body class="index">
<header>
    <form class="search-wrapper" action="/shop/search" method="post">
        <div class="search">
            <div class="fa fa-search">
                <input class="search-sbmt" type="submit">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
            <input type="search" class="search-txt" name="keyword" value="@if(isset($keyword)){{$keyword}}@endif"
                   placeholder="商品搜索：请输入搜索关键字">
        </div>
    </form>
</header>
<div style="height: 38px;"></div>
<main class="content">
     <div class="block-title" style="margin-top: 5px;"><h2><em style="color: #3bb4f2">搜索</em>结果</h2>
        <small style="color: #3bb4f2">S E A R C H</small>
    </div>
    <div class="products products-wrapper">
        @foreach($products as $product)
            <a class="product" id="product-{{$product->id}}" href="/shop/detail?id={{$product->id}}">
                <div class="product-pic">
                    <img src="{{$product->logo}}" alt="">
                </div>
                <div class="product-info">
                    <p class="product-price">
                        <span class="price">&yen;{{$product->price}}</span>
                        <span class="sold-count">已售:{{$product->sold_count}}件</span>
                    </p>
                    <p class="product-name">{{$product->name}}</p>

                </div>
            </a>
        @endforeach
    </div>
    {{--<div class="loading">--}}
    {{--<a class="more">加载更多</a>--}}
    {{--</div>--}}
</main>

@if(!Session::get('baby'))
    <nav class="footer">
        <div class="menus">
            <div class="menu">
                <a href="/shop/index">
                    <i class="fa fa-home"></i>
                    <p>首页</p>
                </a>
            </div>
           <div class="menu">                <a href="/shop/order">                    <i class="fa fa-list-alt"></i>                    <p>我的订单</p>                </a>            </div>            <div class="menu">                <a href="/shop/coupons">                    <i class="fa fa-ticket"></i>                    <p>我的优惠券</p>                </a>            </div>
            <div class="menu">
                <a href="/shop/cart">
                    @if($cartCount)
                        <span class="title-num">{{$cartCount}}</span>
                    @endif
                    <i class="fa fa-shopping-cart"></i>
                    <p>购物车</p>
                </a>
            </div>
            <div class="menu">
                <a href="http://www.ohmate.cn/index.php?g=user&m=center&a=index">
                    <i class="fa fa-user"></i>
                    <p>个人中心</p>
                </a>
            </div>
        </div>
    </nav>
@else
    <nav class="footer">
        <div class="menus">
            <div class="menu" style="width: 33.3%">
                <a href="/shop/baby-index">
                    <i class="fa fa-home"></i>
                    <p>首页</p>
                </a>
            </div>
            <div class="menu" style="width: 33.3%">
                <a href="/shop/cart">
                    @if($cartCount)
                        <span class="title-num">{{$cartCount}}</span>
                    @endif
                    <i class="fa fa-shopping-cart"></i>
                    <p>购物车</p>
                </a>
            </div>
            <div class="menu" style="width: 33.3%">
                <a href="/shop/order">
                    <i class="fa fa-list"></i>
                    <p>订单管理</p>
                </a>
            </div>
        </div>
    </nav>
@endif

<div class="mask-layer">

</div>
<div class="window buy">
    <div class="window-title">
        <div class="preview">
            <img src="http://placeholder.qiniudn.com/100x100" alt="">
        </div>
        <div class="detail">
            <h3 class="title">限量抢购【良品铺子】原味绿豆糕 110g 每个ID限购1份 （全场满68元包邮）</h3>

            <p class="price">
                <span class="unit">&yen;</span>
                <span class="value">5.00</span>
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
                    <a class="btn add-cart">加入购物车</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="notify">
    <p class="notify-inner">添加购物车成功</p>
</div>

<script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="js/libs/jquery.pep.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
</body>
</html>
