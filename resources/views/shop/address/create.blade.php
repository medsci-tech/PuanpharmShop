<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新增地址</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>
<body class="address">
<main class="content">
    <form action="/shop/address/store" method="GET">
        <div class="address-info">
            <div class="block-item">
                <label>收货人</label>
                <input type="text" name="name" class="name" value="" placeholder="名字">
            </div>
            <div class="block-item">
                <label>联系电话</label>
                <input type="text" name="phone" class="phone" value="" placeholder="手机或固话">
            </div>
            <div class="block-item">
                <label>选择地区</label>
                <div class="select-area">
                    <span>
                        <select name="province" id="province" readonly="true"></select>
                    </span>
                    <span>
                        <select name="city" id="city" readonly="true"></select>
                    </span>
                    <span>
                        <select name="district" id="district" readonly="true"></select>
                    </span>
                </div>
            </div>
            <div class="block-item" style="padding-right: 0.3rem">
                <label>详细地址</label>
                <textarea type="text" name="address" class="detail-address" value="" placeholder="街道门牌信息"></textarea>
            </div>
            <div class="block-item">
                <label>邮政编码</label>
                <input type="text" name="zip_code" class="zip-code" value="" placeholder="邮政编码(选填)">
            </div>
            <div class="save" style="display: none;">
                <input type="submit" class="btn" value="保存">
            </div>
        </div>
    </form>
</main>
<div class="mask-layer">

</div>
<div class="notify">
    <p class="notify-inner"></p>
</div>

<nav class="footer create">
    <div class="button save">
        <a class="button-text">保存</a>
    </div>
    <div class="button cancle">
        <a class="button-text">取消</a>
    </div>
</nav>
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
</body>
</html>
