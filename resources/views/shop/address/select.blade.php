<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>地址管理</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>
<body class="address">
<main class="content">
    <div class="address-list">
        <div class="address-container">
            @foreach($addresses as $address)
                <div class="address-item" data-address_id="{{$address['id']}}">
                    <div class="check-container">

                        <span class="check @if($address['default'])
                                checked
                      @endif"></span>
                    </div>
                    <div class="address-item-customer">
                        <span class="address-item-customer-name">{{$address['name']}}</span>
                        <span class="address-item-customer-tel">{{$address['phone']}}</span>
                    </div>
                    <p class="address-item-address">
                        <!-- {{$address['province'].$address['city'].$address['district'].$address['address']}} -->
                        <span class="province">{{ $address['province'] }}</span>
                        <span class="city">{{ $address['city'] }}</span>
                        <span class="district">{{ $address['district'] }}</span>
                        <span class="detail-address-info">{{ $address['address'] }}</span>
                    </p>

                    <div class="address-edit-container">
                        <i>i</i>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="add-address" href="/shop/address/select-create">
            <i class="icon-add"></i>
            <span>新增地址</span>
            <i class="icon-arrow-right"></i>
        </a>
    </div>
</main>
<div class="window address with-delete">
    <div class="window-title">
        <h4 class="title">收货地址</h4>

        <div class="close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
    </div>
    <div class="window-frame">
        <div class="address-info">
            <div class="block-item">
                <label>收货人</label>
                <input type="text" name="name" class="name" value="" placeholder="名字">
            </div>
            <div class="block-item">
                <label>联系电话</label>
                <input type="text" name="phone" value="" class="phone" placeholder="手机或固话">
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
            <div class="block-item">
                <label>详细地址</label>
                <input type="text" name="address" value="" class="detail-address" placeholder="街道门牌信息">
            </div>
            <div class="block-item">
                <label>邮政编码</label>
                <input type="text" name="zip_code" value="" class="zip-code" placeholder="邮政编码(选填)">
            </div>
        </div>
        <div class="save">
            <span class="btn">保存</span>
        </div>
        <div class="delete">
            <span class="btn">删除</span>
        </div>
    </div>
</div>
<nav class="footer">
    <form action="/shop/address/set-default">
        <input type="hidden" class="selected_address" name="address_id">

        <div class="button save">
            <button type="submit" class="button-text">确认</button>
        </div>
        <div class="button cancle">
            <a class="button-text">取消</a>
        </div>
    </form>
</nav>
<div class="notify">
    <p class="notify-inner"></p>
</div>
<div class="mask-layer">

</div>
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
</body>
</html>
