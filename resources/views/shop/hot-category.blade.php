<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>热门分类</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/rebuild.css') }}"/>
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script><script type="text/javascript" src="/shop/js/libs/flexible.js"></script></head>
<body class="category">
<main class="content">
    <div class="categories">
        <div class="block-title" style="margin-top: 5px;"><h2><em>热门</em>分类</h2>
            <small>C A T E G O R I E S</small>
        </div>
        <table>
            @foreach($catArrays as $catArray)
                <tr>
                    @foreach($catArray as $cat)
                        <td>
                            <a href="/shop/category?category_id={{$cat['id']}}">{{$cat['name']}}</a>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
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


<script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/jquery.pep.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
<script>$('.footer').find('.menu a[href="' + window.location.pathname + '"]').parent().addClass('active');</script>
</body>
</html>
