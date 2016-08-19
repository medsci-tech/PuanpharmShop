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
</head>
<body class="category">
<main class="content">
    <div class="categories">
        <h4>热门分类</h4>
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
<script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/jquery.pep.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
</body>
</html>
