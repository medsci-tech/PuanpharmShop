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
</head>
<body class="index">
<!--提示框-->
@if(!empty($fromUrl) && $fromUrl=='tnb')
    <div  class="noticeBox" >
        <img  src='/shop/images/notice.png'/>
        <a class="noticeBtn" ></a>
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
    <main class="content">
        <div class="banner">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($banners as $banner)
                        <a class="swiper-slide" href="{{$banner->href_url}}">
                            <img src="{{$banner->image_url}}" alt="">
                        </a>
                    @endforeach
                </div>
                <div class="banner-img"><img src="/shop/images/banner_img.png" alt=""/></div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="banner">
            <div class="swiper-container">
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
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="ad-box">
            <dl>
                <dt><a href="/shop/activity?activity_id=2"><img
                                src="http://o93nlp231.bkt.clouddn.com/%E7%B3%96%E5%B0%BF%E7%97%85%E4%B8%93%E5%8C%BA.jpg"
                                alt=""/></a></dt>
                <dd><a href="/shop/activity?activity_id=3"><img
                                src="http://o8r5bg2z1.bkt.clouddn.com/%E7%89%B9%E9%85%8D%E5%A5%B6%E7%B2%89.jpg"
                                alt=""/></a></dd>
                <dd style="margin-top: -0.05rem;"><a href="/shop/activity?activity_id=1"><img
                                src="http://o93nlp231.bkt.clouddn.com/%E5%8D%81%E5%85%83%E4%B8%93%E5%8C%BA.jpg"
                                alt=""/></a></dd>
            </dl>
        </div>

        <div class="products products-wrapper">
            @foreach($products as $product)
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
    {{--<script type="text/javascript" src="/shop/js/main.js"></script>--}}
    <script>
        $(function () {
            $('noticeBtn').on('click', function () {
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
            var swiperConfig = {
                pagination: '.swiper-pagination',
                loop: true,
                autoplay: 3000
            };
            var swiper = new Swiper('.swiper-container', swiperConfig);

            function reInitSwiper() {
                setTimeout(function () {
                    swiper.destroy(true, true);
                    swiper = new Swiper('.swiper-container', swiperConfig);
                }, 500);
            }


            $(window).resize(function () {
                reInitSwiper();
            });


            $(window).on('orientationchange', function () {
                reInitSwiper();
            })
        });
    </script>
</body>
</html>
