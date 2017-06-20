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
</head>
<body class="coupon">
<!-- Nav tabs -->
<ul class="nav nav-tabs navbar-fixed-top" role="tablist">
    <li role="presentation" class="active"><a href="#coupons1" aria-controls="coupons1" role="tab" data-toggle="tab">未使用</a>
    </li>
    <li role="presentation"><a href="#coupons2" aria-controls="coupons2" role="tab" data-toggle="tab">已使用</a></li>
    <li role="presentation"><a href="#coupons3" aria-controls="coupons3" role="tab" data-toggle="tab">已过期</a></li>
</ul>

<br><br>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="coupons1">
        <ul class="list-unstyled">
            @foreach($coupons as $coupon) @if( $coupon->used == "0" )
            <li class="coupon-list @if( $coupon->couponType->type == "产品券" )coupon-style-1@elseif( $coupon->couponType->type == "现金券")coupon-style-2@elseif( $coupon->couponType->type == "满减券")coupon-style-3@endif">
                <div class="coupon-header">
                    <div class=coupon-name>{{ $coupon->couponType->type }}</div>
                    <div class="coupon-cut"><small>￥</small>{{ round($coupon->couponType->cut_price) }}</div>
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
    <div role="tabpanel" class="tab-pane" id="coupons2"> <ul class="list-unstyled">
            @foreach($coupons as $coupon) @if( $coupon->used == "1" )
            <li class="coupon-list">
                <div class="coupon-header">
                    <div class=coupon-name>{{ $coupon->couponType->type }}</div>
                    <div class="coupon-cut"><small>￥</small>{{ round($coupon->couponType->cut_price) }}</div>
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
        </ul></div>
    <div role="tabpanel" class="tab-pane" id="coupons3"> <ul class="list-unstyled">
            @foreach($coupons as $coupon) @if( $coupon->used == "0" && strtotime($coupon->expire_at)<=time())
            <li class="coupon-list">
                <div class="coupon-header">
                    <div class=coupon-name>{{ $coupon->couponType->type }}</div>
                    <div class="coupon-cut"><small>￥</small>{{ round($coupon->couponType->cut_price) }}</div>
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
        </ul></div>
</div>

<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>