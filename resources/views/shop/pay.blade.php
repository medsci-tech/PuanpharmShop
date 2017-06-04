<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>付款</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>
<body class="pay" style="background-color: #F8F8F8;font-size:  0.4375rem">
<main class="content">
    <div class="express" is_abroad="{{$is_abroad}}">
        <div class="container">
            @if($address)
                <div class="address item on">
                    <div class="address-panel">
                        <div class="address-detail" data-address_id="{{$address->id}}"
                             data-address_idCard="{{$address->idCard}}">
                            <div class="customer-info">
                                <span class="name">收&nbsp;货&nbsp;人&nbsp;：{{$address->name}}</span>
                                @if($is_abroad == 1)
                                    <span class="name">身&nbsp;份&nbsp;证&nbsp;：{{$address->idCard}}</span>
                                @endif

                            </div>
                            <div class="customer-info" style="margin-top: 0.1rem;">
                                <span class="tel">手&nbsp;机&nbsp;号&nbsp;：{{$address->phone}}</span>
                            </div>
                            <div class="address-detail-info">
                                <p>收货地址：{{$address->province.$address->city.$address->district.$address->address}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-address-tip item on">
                    添加收货地址
                </div>
            @endif
        </div>
    </div>
    <form action="/shop/order/store" method="post" id="pay-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @if($address)
            <input type="hidden" name="address_phone" value="{{$address->phone}}">
            <input type="hidden" name="address_name" value="{{$address->name}}">
            @if($is_abroad == 1)<input type="hidden" name="address_idCard" value="{{$address->idCard}}">@endif
            <input type="hidden" name="address_province" value="{{$address->province}}">
            <input type="hidden" name="address_city" value="{{$address->city}}">
            <input type="hidden" name="address_district" value="{{$address->district}}">
            <input type="hidden" name="address_detail" value="{{$address->address}}">
        @endif
        <div class="goods-list">
            <div class="header">
                <span class="shop">商品列表</span>
            </div>
            <div class="goods">
                @foreach($products as $product)
                    <input type="hidden"
                           name="product[{{sizeof($product->specification) ?$product->id.'-'.$product->specification->id :$product->id}}]"
                           value="{{$product->quantity}}"/>
                    <div class="cart-item">
                        <div class="cart-info">
                            <a href="/shop/detail?id={{$product->id}}" class="preview">
                                <img src="{{$product->logo}}" alt="">
                            </a>

                            <div class="detail">
                                <a href="/shop/detail?id={{$product->id}}" class="goods-link">
                                    <h3 class="goods-title">{{$product->name}}</h3>
                                </a>

                                <p class="goods-weight">{{sizeof($product->specification) ? $product->specification->specification_name : $product->default_spec}}</p>
                            </div>
                            <div class="count">
                                <p class="price">
                                    <span class="unit">&yen;</span>
                                    <span class="value">{{sizeof($product->specification) ?$product->specification->specification_price :$product->price}}</span>
                                </p>

                                <div class="num">
                                    <p class="value">{{$product->quantity}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="block-item price">
            <p>商品合计<span class="num rmb">&yen;{{$productFee}}</span></p>
            {{--@if($productFee >= 99)--}}
            {{--<p>邮费<span class="num rmb"><b>商品满99包邮</b></span></p>--}}
            {{--@else--}}
            {{--<p>邮费<span class="num rmb">&yen;8</span></p>--}}
            {{--@endif--}}

            @if($is_abroad == 1)
                <p>进口税<span class="num rmb">&yen;{{$productTaxFee}}</span></p>
            @endif

            <p>邮费<span class="num rmb">&yen;8</span></p>

            {{--<p>迈豆抵扣<span class="num rmb">&yen;{{$beansFee}} &nbsp;&nbsp;&nbsp;<span--}}
            {{--style="color: #00b7ee">[{{$beansFee*100}}迈豆]</span></span></p>--}}

            <p>使用优惠券<span class="num rmb">
                    <input type="hidden" id="coupon" name="coupon" value="0">
                    <button class="btn-link" type="button" data-toggle="modal" data-target="#myModal">选择优惠券</button>
                </span>
            </p>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">选择优惠券</h4>
                        </div>
                        <div class="modal-body">
                            <ul class="list-unstyled">
                                @foreach($coupons as $coupon)
                                    <li class="list-group-item">
                                        <a style="text-decoration: none!important;" onclick="liclick({{$coupon}})">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    {{ $coupon->coupon_type->name }}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            {{--@if($productFee >= 99)--}}
            {{--<p>实际需付<span class="num rmb" style="color: #f60;font-weight: bold">&yen;{{$productFee}}</span></p>--}}
            {{--@else--}}
            {{--<p>实际需付<span class="num rmb" style="color: #f60;font-weight: bold">&yen;{{$productFee + 8}}</span></p>--}}
            {{--@endif--}}

            <p>实际需付<span id="priceall" class="num rmb"
                         style="color: #f60;font-weight: bold">&yen;{{$productFee+$productTaxFee + 8}}</span>
            </p>
        </div>
        <div class="confirm">
            <input type="hidden" name="address_id" class="selected_address"
                   value="">
            <button type="button" class="next" id="pay-weixin">微信支付</button>
            {{--<button type="submit" class="next">提交</button>--}}
        </div>
        <div class="qrcode" style="width: 60%;margin: 0 auto; margin-top: 10px; display: none">
            <h4 style="width: 100%;text-align: center;margin-bottom: 0.3rem;">微信扫描付款</h4>

            <p style="width: 100%;text-align: center;">长按图片识别二维码支付</p>

            <p style="width: 100%;text-align: center;margin-top: 0.3rem;"><a href="/shop/order">支付成功点我跳转</a></p>
        </div>
    </form>
</main>
<div class="mask-layer">
</div>
<div class="notify">
    <p class="notify-inner"></p>
</div>

<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script>
    var productFee = {{$productFee}};
    var productTaxFee = {{$productTaxFee}};

    function liclick(e) {
        $('#coupon').attr('value',e.id).sibling('button').text(e.coupon_type.name);
        if(e.cut_price){
            var fee = (productFee+productTaxFee-e.cut_price).toFixed(2);
            $('#priceall').text('￥'+fee);
        }
        if(e.cut_percentage){
            var fee = (productFee*(1-e.cut_percentage)+productTaxFee).toFixed(2);
            $('#priceall').text('￥'+fee);
        }
        $('#myModal').modal('hide');
    }
</script>
<script type="text/javascript">
    var is_abroad = parseInt('{{$is_abroad}}'); // 是否包含海淘
    var $maskLayer = $('.mask-layer');
    function showMaskLayer(show) {
        return show ? $maskLayer.show() : $maskLayer.hide();
    }
    var $notify = $('.notify');
    function showNotify(text, timeout) {
        showMaskLayer(true);
        //$notify.fadeIn();
        $notify.find('.notify-inner').html(text);
        $notify.fadeIn();
        setTimeout(function () {
            $notify.fadeOut();
            showMaskLayer(false);
        }, timeout);
    }

    $('#pay-weixin').on('click', function () {
        // 地址验证
        var id = $('.address-detail').attr('data-address_id');
        var idCard = $('.address-detail').attr('data-address_idCard'); //身份证
        if (!id) {
            showNotify('地址不能为空！', 3000);
            return false;
        }
        if (is_abroad) {
            if (!idCard) {
                showNotify('身份证号码不能为空！', 3000);
                return false;
            }

        }

        var payButton = $('#pay-weixin');
        payButton.attr('disabled', "true");
        payButton.html("支付中...");

        $.post('/shop/order/store',
            $('#pay-form').serialize(),
            function (data) {
                if (data.success) {
                    console.log(JSON.stringify(data));

                    function onBridgeReady() {
                        WeixinJSBridge.invoke(
                            'getBrandWCPayRequest', JSON.parse(data.data.result),
                            function (res) {

                                if (res.err_msg == "get_brand_wcpay_request:ok") {
                                    window.location.href = "/shop/pay-success";
                                } // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。

                                if (res.err_msg == "get_brand_wcpay_request:cancel") {
                                    payButton.removeAttr('disabled');
                                    payButton.html("微信支付");
                                }

                                if (res.err_msg == "get_brand_wcpay_request:fail") {
                                    alert("请长按识别下方二维码付款。");
                                    payButton.html("长按下方图片识别二维码支付");
                                    console.log(data.data.out_trade_no);
                                    $.ajax({
                                        url: '/shop/get_code_url',
                                        method: 'GET',
                                        data: {
                                            out_trade_no: data.data.out_trade_no
                                        }
                                    }).done(function (data) {
                                        console.log(JSON.stringify(data.data.codeUrl));
                                        img = '<img src="' + data.data.codeUrl + '">';
                                        $('h4').after(img);
                                        $('.qrcode').show();
                                    });
                                }
//                                        if (res.err_code == 3) {
//                                            alert("请长按识别下方二维码付款。");
//                                            payButton.html("长按下方图片识别二维码支付");
//                                            console.log(data.data.out_trade_no);
//                                            $.ajax({
//                                                url: '/shop/get_code_url',
//                                                method: 'GET',
//                                                data: {
//                                                    out_trade_no: data.data.out_trade_no
//                                                }
//                                            }).done(function (data) {
//                                                console.log(JSON.stringify(data.data.codeUrl));
//                                                img = '<img src="' + data.data.codeUrl + '">';
//                                                $('h4').after(img);
//                                                $('.qrcode').show();
//                                            });
//                                        }
                            }
                        );
                    }

                    if (typeof WeixinJSBridge == "undefined") {
                        if (document.addEventListener) {
                            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                        } else if (document.attachEvent) {
                            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                        }
                    } else {
                        onBridgeReady();
                    }
                } else {
                    alert('服务器异常!');
                }
            }, "json"
        );
    })
</script>
<script type="text/javascript" src="/shop/js/main.js"></script>
<script>
    if (is_abroad)
        showNotify('根据中华人民共和国务院令第392号《中华人民共和国进出口关税条例》规定，中华人民共和国准许进口的货物、进境物品，海关需收进口关税(每月3笔，每比2000，每年不超过2万元加一起', 8000);
</script>
</body>
</html>
