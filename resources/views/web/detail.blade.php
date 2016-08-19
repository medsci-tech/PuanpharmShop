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
            <span>&yen;</span>
            <span class="current">{{$product->price}}</span>
            <span class="original">/{{$product->beans}}迈豆</span>
        </div>

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

<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="/shop/js/libs/jquery.pep.js"></script>
<script type="text/javascript" src="/shop/js/main.js"></script>
</body>
</html>
