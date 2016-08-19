<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>我的迈豆</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>
@if($monthsBeans)
    <body class="beans">
    <main class="content">
        <div class="shop-list">
            @foreach($monthsBeans as $month => $beans)
                @if($month == $now)
                    <div class="header" style="background-color: #e5e5e5;">
                        <a href="#" class="beans"><strong>本月</strong></a>
                        {{--<a href="#" class="monthly">查看月账单<i class="icon-arrow-right"></i></a>--}}
                    </div>
                    @foreach($beans as $bean)
                        <div class="cart-list" style="border-bottom: 0.03125rem solid #e5e5e5;">
                            <div class="cart-item">
                                <div class="bean-date">
                                    <p class="date">{{$bean->created_at->format('m-d')}}</p>

                                    <p class="time">{{$bean->created_at->format('h:m')}}</p>
                                </div>
                                <div class="bean-detail" style="padding-left: 1.2rem">
                                    <p class="count">{{$bean->beans}}</p>

                                    <p class="location">消费返现</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="header" style="background-color: #e5e5e5;">
                        <a href="#" class="beans"><strong>{{$month}}</strong></a>
                        {{--<a href="#" class="monthly">查看月账单<i class="icon-arrow-right"></i></a>--}}
                    </div>
                    @foreach($beans as $bean)
                        <div class="cart-list" style="display: none;">
                            <div class="cart-item">
                                <div class="bean-date">
                                    <p class="date">{{$bean->created_at->format('Y-m')}}</p>

                                    <p class="time">{{$bean->created_at->format('hh:mm')}}</p>
                                </div>
                                <div class="bean-detail">
                                    <p class="count">-239.90</p>

                                    <p class="location">沃尔玛</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>
        </div>
    </main>
    <nav class="footer">
        <a href="/shop/index" class="home fa fa-home" aria-hidden="true"></a>

        <div class="menus">
            <div class="menu">
                <a href="/shop/category" class="menu-name fa fa-pause-circle">商品分类</a>
            </div>
            <div class="menu">
                <span class="menu-name fa fa-pause-circle">特惠专区</span>

                <div class="sub-menu">
                    <ul>
                        <li class="sub-menu-item">
                            <a href="">活动一</a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="">活动二</a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="">活动三</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="menu">
                <a href="/shop/personal" class="menu-name fa fa-pause-circle">个人中心</a>
            </div>
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
                <h4>您暂时还没有积分入账</h4>
                <span>快给我挑点宝贝</span>
            </div>
            <!-- 自定义html，和上面的可以并存 -->
            <div class="empty-list-content">
                <a href="/shop/index" class="empty-btn">去逛逛</a>
            </div>
        </div>
    </main>
    <nav class="footer">
        <a href="/shop/index" class="home fa fa-home" aria-hidden="true"></a>

        <div class="menus">
            <div class="menu">
                <a href="/shop/category" class="menu-name fa fa-pause-circle">商品分类</a>
            </div>
            <div class="menu">
                <span class="menu-name fa fa-pause-circle">特惠专区</span>

                <div class="sub-menu">
                    <ul>
                        <li class="sub-menu-item">
                            <a href="">活动一</a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="">活动二</a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="">活动三</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="menu">
                <a href="/shop/personal" class="menu-name fa fa-pause-circle">个人中心</a>
            </div>
        </div>
    </nav>
    <script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
    <script type="text/javascript" src="/shop/js/components.js"></script>
    <script type="text/javascript" src="/shop/js/main.js"></script>
    </body>
@endif
</html>
