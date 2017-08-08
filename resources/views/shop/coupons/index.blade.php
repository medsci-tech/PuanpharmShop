<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>优惠券</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/shop/css/font-awesome.min.css">
    <link rel="stylesheet" href="/shop/css/rebuild.css">
    <script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
</head>
<body class="coupon">
<!-- Nav tabs -->
<ul class="nav nav-tabs navbar-fixed-top" role="tablist">
    <li role="presentation" class="active"><a href="#coupons1" aria-controls="coupons1" role="tab"
                                              data-toggle="tab">未使用</a>
    </li>
    <li role="presentation"><a href="#coupons2" aria-controls="coupons2" role="tab" data-toggle="tab">已使用</a></li>
    <li role="presentation"><a href="#coupons3" aria-controls="coupons3" role="tab" data-toggle="tab">已过期</a></li>
    <li role="presentation"><a href="#coupons4" aria-controls="coupons4" role="tab" data-toggle="tab"><i
                    class="fa fa-question-circle-o">说明</i></a></li>
</ul>

<br><br>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="coupons1">
        <ul class="list-unstyled">
            @foreach($coupons as $coupon) @if( $coupon->used == "0" && strtotime($coupon->expire_at)>=time())
                <li class="coupon-list @if( $coupon->couponType->type == "产品券"  || $coupon->couponType->type == "兑换券" )
                        coupon-style-1
@elseif( $coupon->couponType->type == "现金券")
                        coupon-style-2
@elseif( $coupon->couponType->type == "满减券")
                        coupon-style-3
@else
                        coupon-style-1
@endif
                        ">
                    <div class="coupon-header">
                        <div class=coupon-name>{{ $coupon->couponType->type }}</div>
                        <div class="coupon-cut">
                            <small>￥</small>{{ round($coupon->couponType->cut_price) }}</div>
                    </div>
                    <div class="coupon-circle-1"></div>
                    <div class="coupon-circle-2"></div>
                    <div class="coupon-body">
                        <div class="coupon-detail">
                            <p>{{ $coupon->couponType->name }}</p>
                            <p>使用条件请查看商品详情页的满减规则</p>
                            <p>有效期至：{{ $coupon->expire_at }}</p>
                        </div>
                        <div class="coupon-link">
                            @if($coupon->couponType->product_id_required)
                                <a href="/shop/detail?id={{$coupon->couponType->product_id_required}}">去使用></a>
                            @else
                                <a href="/shop/index">去使用></a>
                            @endif
                        </div>
                    </div>
                </li>
            @endif @endforeach
        </ul>
    </div>
    <div role="tabpanel" class="tab-pane" id="coupons2">
        <ul class="list-unstyled">
            @foreach($coupons as $coupon) @if( $coupon->used == "1" )
                <li class="coupon-list">
                    <div class="coupon-header">
                        <div class=coupon-name>{{ $coupon->couponType->type }}</div>
                        <div class="coupon-cut">
                            <small>￥</small>{{ round($coupon->couponType->cut_price) }}</div>
                    </div>
                    <div class="coupon-circle-1"></div>
                    <div class="coupon-circle-2"></div>
                    <div class="coupon-body">
                        <div class="coupon-detail">
                            <p>{{ $coupon->couponType->name }}</p>
                            <p>使用条件请查看商品详情页的满减规则</p>
                            <p>有效期至：{{ $coupon->expire_at }}</p>
                        </div>
                        <div class="coupon-link">
                            <a class="coupon-used">已使用</a>
                        </div>
                    </div>
                </li>
            @endif @endforeach
        </ul>
    </div>
    <div role="tabpanel" class="tab-pane" id="coupons3">
        <ul class="list-unstyled">
            @foreach($coupons as $coupon) @if( $coupon->used == "0" && strtotime($coupon->expire_at)<time())
                <li class="coupon-list">
                    <div class="coupon-header">
                        <div class=coupon-name>{{ $coupon->couponType->type }}</div>
                        <div class="coupon-cut">
                            <small>￥</small>{{ round($coupon->couponType->cut_price) }}</div>
                    </div>
                    <div class="coupon-circle-1"></div>
                    <div class="coupon-circle-2"></div>
                    <div class="coupon-body">
                        <div class="coupon-detail">
                            <p>{{ $coupon->couponType->name }}</p>
                            <p>使用条件请查看商品详情页的满减规则</p>
                            <p>有效期至：{{ $coupon->expire_at }}</p>
                        </div>
                    </div>
                </li>
            @endif @endforeach
        </ul>
    </div>
    <div role="tabpanel" class="tab-pane" id="coupons3">
        <p class="strong">1. 什么是易康优惠券？</p>
        <p>易康优惠券是为易康商城发行和认可的购物券，可在易康商城Web版和易康伴侣、普安易康微信公众号，商城频道中下单时使用，可抵扣相应的金额。</p>
        <br>
        <p class="strong">2. 易康优惠券的使用条件？</p>
        <p>使用优惠券需同时满足以下条件：</p>
        <p>（1）商品价超过券上的金额才可使用支付优惠券；</p>
        <p>（2）仅限在线支付使用，且收货人手机号、领取优惠券时输入的手机号和账号中的手机号需为同一手机号；</p>
        <p>（3）优惠券有品类及金额限制，需要在对应品类下且满足限制金额后才可使用；</p>
        <p>（4）每个订单只能使用一张优惠券。</p>
        <br>
        <p class="strong">3. 首单优惠券的使用条件？</p>
        <p>首单优惠券需同时满足以下条件才可用，且首单优惠券不与其他优惠（首减、满减、满赠、折扣）同享:</p>
        <p>（1）新用户（设备、手机号、易康账号均未在易康商城下过单）首次下单；</p>
        <p>（2）仅限在线支付使用，且收货人手机号、领取优惠券时输入的手机号和账号中的手机号需为同一手机号。</p>
        <br>
        <p class="strong">4. 如何获取易康优惠券？</p>
        <p>易康商城会在线上不定期的举办送优惠券的活动。通过易康商城Web，或易康伴侣公众号内进行活动参与或使用M豆进行优惠券兑换。</p>
        <br>
        <p class="strong">5. 易康优惠券可以找零、转赠、现金购买吗？</p>
        <p>易康优惠券不找零、不能转赠、不可现金购买。</p>
        <br>
        <p class="strong">6. 为什么账户里找不到领取的优惠券？</p>
        <p>(1) 请确保领取优惠券的手机号和账号绑定的手机号一致；</p>
        <p>(2) 优惠券可能已经过期或被冻结，可以在过期券列表中查看；</p>
        <p>(3) 折扣券、含小数点的优惠券及部分其他类型优惠券仅在最新商城页面内才能查看。</p>
        <br>
        <p class="strong">7. 易康商城优惠券可以在其他平台商城使用吗？</p>
        <p>易康优惠券仅限在易康商城内使用，不可在微信钱包、手机QQ等其他平台商城使用。</p>
    </div>
</div>

<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>