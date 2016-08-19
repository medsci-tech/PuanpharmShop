<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    {{--<meta name="viewport"--}}
    {{--content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">--}}
    <link rel="stylesheet" href="{{ asset('/personal/css/weui.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/personal/css/member.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>
<body class="personal">
<header>

</header>
<main class="content">
    <div class="hd img_t">
        <img src="{{$customer->head_image_url}}">
    </div>
    <div class="user-info">
        <div class="block block-list">
            <a class="block-item link" href="/shop/order" target="_blank">
                <i class="fa fa-file-text" aria-hidden="true"></i>

                <p class="title">&nbsp;全部订单</p>
                <i class="fa fa-angle-right right" aria-hidden="true"></i>
            </a>
        </div>
        <div class="block block-list">
            {{--<a class="block-item link" href="/shop/personal/beans" target="_blank">--}}
            {{--<i class="fa fa-btc" aria-hidden="true"></i>--}}

            {{--<p class="title">&nbsp;&nbsp;我的迈豆</p>--}}
            {{--<i class="fa fa-angle-right right" aria-hidden="true"></i>--}}
            {{--</a>--}}
            <a class="block-item link" href="/shop/address" target="_blank">
                <i class="fa fa-bus" aria-hidden="true"></i>

                <p class="title">&nbsp;地址管理</p>
                <i class="fa fa-angle-right right" aria-hidden="true"></i>
            </a>
        </div>
        <div class="block block-list">
            <a class="block-item link" href="/shop/personal/rule" target="_blank">
                <i class="fa fa-code" aria-hidden="true"></i>

                <p class="title">迈豆规则</p>
                <i class="fa fa-angle-right right" aria-hidden="true"></i>
            </a>
            <a class="block-item link" href="/shop/personal/about-us" target="_blank">
                <i class="fa fa-certificate" aria-hidden="true"></i>

                <p class="title">&nbsp;关于我们</p>
                <i class="fa fa-angle-right right" aria-hidden="true"></i>
            </a>
        </div>
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

<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
</body>
</html>
