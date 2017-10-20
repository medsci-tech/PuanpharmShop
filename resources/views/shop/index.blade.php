<!doctype html>
<html>
<head>
    <div style="display: none">

    @if(Session::get('baby_shop', 0) == 1)
            <img src="{{ asset('/shop/images/logo/kaisite.jpg')}}" alt="">
    @elseif(Session::get('baby_shop', 0) == 2)
            <img src="{{ asset('/shop/images/logo/puan.jpg')}}" alt="">
    @else
            <img src="{{ asset('/shop/images/logo/yikang.jpg')}}" alt="">
    @endif

    </div>
    <meta charset="UTF-8">
    <title>
        @if(Session::get('baby_shop', 0) == 1)
            凯特斯国际儿童生活馆门店
        @elseif(Session::get('baby_shop', 0) == 2)
            普安大药房门店
        @else
            易康商城
        @endif
    </title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/rebuild.css') }}"/>
    <script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
</head>
<body class="index">
<!--提示框-->
@if(!empty($fromUrl) && $fromUrl=='tnb')
    <div class="noticeBox">
        <img src='/shop/images/notice.png'/>
        <a class="noticeBtn"></a>
    </div>
    <div class="noticeBg"></div>
@endif
<!---end-->
<header>
    <form class="search-wrapper" action="/shop/search" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="search">
            <div class="fa fa-search">
                <input class="search-sbmt" type="submit">
            </div>
            <input type="search" class="search-txt" name="keyword" placeholder="商品搜索：请输入搜索关键字">
        </div>
    </form>
</header>
<div style="height: 38px;"></div>
<main class="content">
    <div class="banner">
        <div class="swiper-container" id="swiper1">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                    <a class="swiper-slide" href="{{$banner->href_url}}">
                        <img src="{{$banner->image_url}}" alt="">
                    </a>
                @endforeach
            </div>
            <!-- If we need pagination -->
            <div id="swiper-pagination1"></div>
        </div>
    </div>

    <div class="banner">
        <div class="swiper-container" id="swiper2">
            <div class="swiper-wrapper">
                @foreach($catArrays as $catArray)
                    <div class="categories swiper-slide">
                        <div class="quick-entry-nav">
                            @foreach($catArray as $cat)
                                <a href="/shop/category?category_id={{$cat['id']}}" class="quick-entry-link">
                                    <img src="{{$cat['logo']}}">
                                    <span>{{$cat['name']}}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- If we need pagination -->
            <div id="swiper-pagination2"></div>
        </div>
    </div>

    @if(!Session::get('baby'))
        <div class="block-title"><h2><em>特惠</em>专区</h2>
            <small>D I S C O U N T</small>
        </div>

        <div class="ad-box">
            <dl>
                <dt><a href="/shop/activity?activity_id=2"><img
                                src="http://o93nlp231.bkt.clouddn.com/%E7%94%9C%E8%9C%9C%E5%AE%B6%E5%9B%AD1.jpg"
                                alt=""/></a></dt>
                <dd><a href="/shop/activity?activity_id=3"><img
                                src="http://o93nlp231.bkt.clouddn.com/%E6%B5%B7%E5%A4%96%E7%9B%B4%E9%82%AE1.jpg"
                                alt=""/></a></dd>
                <dd style="margin-top: 0.02rem;"><a href="/shop/activity?activity_id=1"><img
                                src="http://o93nlp231.bkt.clouddn.com/%E6%AF%8D%E5%A9%B4%E4%B8%93%E5%8C%BA1.jpg"
                                alt=""/></a></dd>
            </dl>
        </div>
    @endif

    <div class="block-title"><h2><em style="color: #da8f11;">热销</em>商品</h2>
        <small style="color: #da8f11;">P O P U L A R</small>
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
                        @if($product->on_sale)
                            <span class="sale" style="font-size:50%;color: #ff0000;">特价</span>
                        @endif
                        <span class="sold-count">已售:{{$product->sold_count}}件</span>
                    </p>

                    <p class="product-name">{{$product->name}}</p>
                </div>
                {{--@if($product->is_on_sale)--}}
                {{--<span class="buy">购买</span>--}}
                {{--@else--}}
                {{--<span class="disabled-buy">不可购买</span>--}}
                {{--@endif--}}

            </a>
        @endforeach
    </div>
    <div class="loading">
        <a class="more">没有更多商品了</a>
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

<script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="/shop/js/libs/jquery.pep.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
{{--<script type="text/javascript" src="/shop/js/main.js"></script>--}}
<script>
    $(function () {
        $('.noticeBtn').on('click', function () {
            $('.noticeBox').hide();
            $('.noticeBg').hide();
        });

        $('nav .menu').on('click', function (event) {
            $(this).find('.sub-menu').toggle();
            $(this).siblings().find('.sub-menu').fadeOut();

            event.stopPropagation();
        });

        $(document.body).on('click', function () {
            $('.sub-menu').fadeOut();
        });

        if (typeof Swiper !== 'function') {
            return;
        }
        var swiper1 = new Swiper('#swiper1', {
            pagination: '#swiper-pagination1',
            loop: true,
            autoplay: 3000
        });
        var swiper2 = new Swiper('#swiper2', {
            pagination: '#swiper-pagination2'
        });
        $('.footer').find('.menu a[href="' + window.location.pathname + '"]').parent().addClass('active');
    });


    var a_logo = '';
    @if(Session::get('baby_shop', 0) == 1)
            a_logo = '/shop/images/logo/kaisite.jpg';
    @elseif(Session::get('baby_shop', 0) == 2)
            a_logo = '/shop/images/logo/puan.jpg';
    @else
            a_logo = '/shop/images/logo/yikang.jpg';
    @endif
    wx.config(<?php echo $js->config(array('onMenuShareAppMessage','onMenuShareTimeline')) ?>);
    wx.ready(function () {
      wx.onMenuShareAppMessage({
        title: document.title,
        desc: '欢迎来到'+document.title, // 分享描述
//        link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
//        imgUrl: a_logo, // 分享图标
        success: function () {
          // 用户确认分享后执行的回调函数
        },
        cancel: function () {
          // 用户取消分享后执行的回调函数
        }
      });
      wx.onMenuShareTimeline({
        title: document.title, // 分享标题
        link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: a_logo, // 分享图标
        success: function () {
          // 用户确认分享后执行的回调函数
        },
        cancel: function () {
          // 用户取消分享后执行的回调函数
        }
      });
    });
</script>
</body>
</html>
