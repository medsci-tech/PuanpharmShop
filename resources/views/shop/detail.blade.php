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
<!--<header>-->
<!---->
<!--</header>-->
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
            <span>&yen;</span>
            <span class="current">{{$product->price}}</span>
            <span class="original">/{{$product->beans}}迈豆</span>
        </div>
        {{--<div class="trade-reward">--}}
        {{--<span class="trade-reward-tag">优惠</span>--}}
        {{--<span class="trade-reward-info">满99元包邮</span>--}}
        {{--</div>--}}
        <div class="goods-info">
            @if($product->default_spec)
                <div class="specifications specifications">
                    <span class="info-name">规格:</span>
                    <span class="info">{{$product->default_spec}}</span>
                </div>
            @endif
            <div class="specifications" style="border-bottom: 0.03125rem solid #f2f2f2;">
                <span class="info-name">运费:</span>
                <span class="info">&yen; 8.00</span>
            </div>
        </div>

        <div class="trade-reward">
            <span class="trade-reward-info">此商品由普安药房实际运营并负责发货</span>
        </div>

    </div>
        {{--<div class="store-info">--}}
        {{--<div class="store">--}}
        {{--<a class="store-link fa fa-shopping-bag" href="#">此商品由普安药房实际运营并负责发货</a>--}}
        {{--</div>--}}
        {{--<div class="store">--}}
        {{--<a class="store-link fa fa-map-marker" href="#">线下商店</a>--}}
        {{--</div>--}}
    {{--<div class="verification">--}}
    {{--<p class="verify fa fa-check-circle">企业认证</p>--}}

    {{--<p class="verify fa fa-check-circle">企业认证</p>--}}

    {{--<p class="verify fa fa-check-circle">企业认证</p>--}}
    {{--</div>--}}
    {{--</div>--}}
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
    {{--<div class="button chufang on">--}}
    {{--<a class="button-text">需求登记</a>--}}
    {{--</div>--}}
    @if($product->is_on_sale)
        <div class="button buy on">
            <a class="button-text">立即购买</a>
        </div>
        <div class="button cart">
            <a class="button-text">加入购物车</a>
        </div>
    @else
        <span class="disabled-buy" style="width: 100%;">不可购买</span>
    @endif

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

            <form action="/shop/pay" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="spec_id" value="" class="spec_id">
                {{--<input type="hidden" name="product_id" value="{{$product->id}}" class="added-product-id">--}}
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

<div class="window chufang">
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
                @if(sizeof($product->specifications))
                    @foreach($product->specifications as $spec)
                        <span class="tag" price="{{$spec->specification_price}}"
                              spec_id="{{$spec->id}}">{{$spec->specification_name}}</span>
                    @endforeach
                @endif
            </div>
            <form action="/shop/pay" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                {{--<input type="hidden" name="product_id" value="{{$product->id}}" class="added-product-id">--}}
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
                <div class="chufang-upload">
                    <div class="block-item">
                        <label for="cf_name">姓名</label><input type="text" id="cf_name" name="cf_name" value="">
                    </div>
                    <div class="block-item">
                        <label for="cf_name">联系方式</label><input type="text" id="cf_name" name="cf_name" value="">
                    </div>
                    <div class="block-item">
                        <label for="cf_image">上传处方</label>
                        <input type="text" readonly="true" style="width: 2.2rem;text-align:left;" value=""
                               id="file-name">
                        <span class="upload">选择要上传的文件</span>
                        <input type="file" id="cf_image" name="cf_image" value="" multiple="multiple">
                    </div>
                    {{--<div class="block-item">--}}
                    {{--<label for="cf_type">处方类型</label>--}}
                    {{--<select id="cf_type" class="" name="cf_type">--}}
                    {{--<option value="处方">处方</option>--}}
                    {{--<option value="非处方">非处方</option>--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    <div class="block-item">
                        <label for="cf_msg">需求描述</label>
                        <textarea name="cf_msg" id="cf_msg"></textarea>
                    </div>
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
    <a href="/shop/cart">
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

<script type="text/javascript">
    document.getElementById("cf_image").onchange = function () {
        document.getElementById("file-name").value = this.value;
    };
</script>
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="/shop/js/libs/jquery.pep.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
</body>
</html>
