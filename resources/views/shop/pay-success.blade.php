<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>支付成功</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>

<body class="empty">
<main class="content">
    <div class="empty-list " style="padding-top:60px;">
        <!-- 文本 -->
        <div class="empty-list-header">
            <h4>支付成功</h4>
            <span>您现在可以</span>
        </div>
        <div class="empty-list-content">
            <a href="/shop/index" class="empty-btn">回到首页</a>
            <a href="/shop/order" class="empty-btn">查看订单</a>
        </div>
    </div>
</main>
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
</body>
</html>
