<!DOCTYPE html>
<html class="js cssanimations">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>商城后台管理</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <link rel="icon" type="image/png" href="/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="商城后台管理">
    <link rel="stylesheet" href="{{ asset('/admin/css/amazeui.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/admin/css/admin.css') }}"/>
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器,我们暂不支持。 请 <a href="http://browsehappy.com/"
                                                                 target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
        <strong>商城</strong>
        <small>后台管理</small>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
            data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span
                class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li class="am-dropdown" data-am-dropdown="">
                <a class="am-dropdown-toggle" data-am-dropdown-toggle="" href="javascript:;">
                    <span class="am-icon-user"></span> 管理员 <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    {{--<li><a href="#"><span class="am-icon-user"></span> 资料</a></li>--}}
                    {{--<li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>--}}
                    <li><a href="/admin/logout"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span
                            class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                {{--<li><a href="/"><span class="am-icon-home"></span> 首页</a></li>--}}
                <li><a href="/admin/user"><span class="am-icon-users"></span>用户管理</a></li>
                <li><a href="/admin/order"><span class="am-icon-file"></span> 订单管理</a></li>
                <li><a href="/admin/banner"><span class="am-icon-th"></span> 首页Banner</a></li>
                <li><a href="/admin/cooperator"><span class="am-icon-th"></span> 接入管理</a></li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}"><span
                                class="am-icon-product-hun"></span>
                        商品管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">
                        <li><a href="/admin/product" class="am-cf"><span class="am-icon-calendar"></span>商品管理</a></li>
                        <li><a href="/admin/specification"><span class="am-icon-puzzle-piece"></span>规格管理</a></li>
                        <li><a href="/admin/product-banner"><span class="am-icon-th"></span></span>Banner管理</a></li>
                    </ul>
                </li>
                <li><a href="/admin/category"><span class="am-icon-pencil-square-o"></span>产品分类</a></li>
                <li><a href="/admin/supplier"><span class="am-icon-bank"></span>供应商管理</a></li>
                <li><a href="/admin/activity"><span class="am-icon-bookmark"></span>活动管理</a></li>

                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#member-nav'}"><span
                                class="am-icon-product-hun"></span>
                        外接商城 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub am-in" id="member-nav">
                        <li><a href="/admin/member/product" class="am-cf"><span class="am-icon-calendar"></span>商品管理</a>
                        </li>
                        <li><a href="/admin/member/member-order" class="am-cf"><span
                                        class="am-icon-file"></span>App订单</a></li>
                        <li><a href="/admin/member/wx-order"><span class="am-icon-puzzle-file"></span>微信订单</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- sidebar end -->

    <!-- content start -->
    @yield('main','content')
            <!-- content end -->

</div>

<a href="#" class="am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}">
    <span class="am-icon-btn am-icon-th-list"></span>
</a>

{{--<footer>--}}
{{--<hr>--}}
{{--<p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>--}}
{{--</footer>--}}

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/admin/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="/admin/js/amazeui.min.js"></script>
<script src="/admin/js/app.js"></script>


<div id="cntvlive2-is-installed"></div>
</body>
</html>

