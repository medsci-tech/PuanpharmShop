<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商品详情</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>
<body class="detail">

<main class="content">
    @if(count($product->banners))
        <div class="banner">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($product->banners as $banner)
                        <a class="swiper-slide" href="">
                            <img src="{{$banner->image_url}}" alt="">
                        </a>
                    @endforeach
                </div>
                @if(count($product->banners) >1)
                    <div class="swiper-pagination" style="bottom: 4px;"></div>
                @endif
            </div>
        </div>
    @endif

    <div class="goods" id="product-{{$product->id}}">
        <div class="goods-header">
            <h2 class="title">{{$product->name}}</h2>
        </div>
        <div class="goods-price">
            <span class="current">{{$product->beans}}糖豆</span>
        </div>
        <div class="goods-info">
            @if($product->default_spec)
                <div class="specifications specifications">
                    <span class="info-name">规格:</span>
                    <span class="info">{{$product->default_spec}}</span>
                </div>
            @endif
        </div>
    </div>
    <div class="trade-detail">
        <div class="tab-nav">
            <span class="nav-btn current">商品详情</span>
            <span class="nav-btn">商品成交</span>

            <div class="tabs">
                <div class="tab  current">
                    {!! $product->detail !!}
                </div>
                <div class="tab">
                    <div class="trade-list-header">
                        <span class="col">买家</span>
                        <span class="col">成交时间</span>
                        <span class="col">数量</span>
                    </div>
                    <div class="trade-list">
                        @foreach($product->orders as $order)
                            @if($order->payment_status)
                                <div class="trade block-item">
                                    <span class="col address-name">{{\App\Models\Customer::find($order->customer_id)->nickname}}</span>
                                    <span class="col">{{$order->created_at}}</span>
                                    <span class="col">{{$order->pivot->quantity}}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<nav class="footer">
    <div class="button buy on">
        <a class="button-text">立即购买</a>
    </div>
    <div class="button cart">
        <a class="button-text">加入购物车</a>
    </div>
</nav>
<div class="mask-layer">

</div>

<div class="window buy">
    <div class="window-title">
        <div class="preview">
            <img src="{{$product->logo}}" alt="">
        </div>
        <div class="detail">
            <h3 class="title">{{$product->name}}</h3>

            <p class="price">
                <span class="unit">&yen;</span>
                <span class="value">{{$product->price}}</span>
            </p>
        </div>
        <div class="close">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
        </div>
    </div>
    <div class="window-frame">
        <div class="view">
            <div class="item-info">
                <p class="info-title">规格（粒/袋/ml/g）：</p>
            </div>
            <div class="specific">
                <span class="tag active" price="{{$product->price}}">{{$product->default_spec}}</span>
                @if(sizeof($product->specifications))
                    @foreach($product->specifications as $spec)
                        <span class="tag" price="{{$spec->specification_price}}"
                              spec_id="{{$spec->id}}">{{$spec->specification_name}}</span>
                    @endforeach
                @endif
            </div>

            <form action="/wx/pay" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="spec_id" value="" class="spec_id">
                <div class="buy">
                    <div class="quantum">
                        <span>购买数量：</span>

                        <div class="quantity">
                            <div class="btn minus disabled">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </div>
                            <input class="txt" type="text" name="quantity" value="1">

                            <div class="btn plus">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    {{--<div class="other-info">--}}
                    {{--<p class="quota">每人限购1件</p>--}}
                    {{--</div>--}}
                </div>
                <div class="confirm">
                    <button type="submit" class="next">购买</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="window cart">
    <div class="window-title">
        <div class="preview">
            <img src="{{$product->logo}}" alt="">
        </div>
        <div class="detail">
            <h3 class="title">{{$product->name}}</h3>

            <p class="price">
                <span class="unit">&yen;</span>
                <span class="value">{{$product->price}}</span>
            </p>
        </div>
        <div class="close">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
        </div>
    </div>
    <div class="window-frame">
        <div class="view">
            <div class="item-info">
                <p class="info-title">规格（粒/袋/ml/g）：</p>
            </div>
            <div class="specific">
                <span class="tag active" price="{{$product->price}}">{{$product->default_spec}}</span>
                @if(sizeof($product->specifications))
                    @foreach($product->specifications as $spec)
                        <span class="tag" price="{{$spec->specification_price}}"
                              spec_id="{{$spec->id}}">{{$spec->specification_name}}</span>
                    @endforeach
                @endif
            </div>
            <div class="buy">
                <input type="hidden" name="id" value="" class="added-product-id">
                <input type="hidden" name="spec_id" value="" class="spec_id">

                <div class="quantum">
                    <span>购买数量：</span>

                    <div class="quantity">
                        <div class="btn minus disabled">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </div>
                        <input class="txt" type="text" name="quantity" value="1">

                        <div class="btn plus">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                {{--<div class="other-info">--}}
                {{--<p class="quota">每人限购1件</p>--}}
                {{--</div>--}}
            </div>
            <div class="confirm">
                <a class="next">加入购物车</a>
            </div>
        </div>
    </div>
</div>

<div class="global-cart">
    <a href="/wx/cart">
        @if($cartCount)
            <span class="title-num">{{$cartCount}}</span>
        @else
            <span class="title-num">0</span>
        @endif
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    </a>
</div>

<div class="notify">
    <p class="notify-inner">添加购物车成功</p>
</div>

<script type="text/javascript" src="/member/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/member/js/libs/flexible.js"></script>
<script type="text/javascript" src="/member/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/member/js/components.js"></script>
<script type="text/javascript" src="/member/js/libs/jquery.pep.js"></script>
<script type="text/javascript" src="/wx/js/main.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    $(function () {

			
	//微信jssdk	
	
	wx.config({
		debug: false,
		appId:'<?php echo $signPackage["appId"];?>',
		timestamp: <?php echo $signPackage["timestamp"];?>,
		nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		signature: '<?php echo $signPackage["signature"];?>',
		jsApiList: [
			'checkJsApi',
			'hideOptionMenu',
			
		]
	});

	wx.ready(function () {
		wx.hideOptionMenu();
		
	});
	wx.error(function (res) {
	   alert(res.errMsg);
	});

		
    });
</script>
</body>
</html>
