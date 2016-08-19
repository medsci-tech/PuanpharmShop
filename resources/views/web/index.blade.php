<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>普安易康</title>
    <link rel="stylesheet" href="{{asset('/shop/css/swiper-3.3.0.min.css')}}">
    <link rel="stylesheet" href="{{asset('/shop/css/shop_rebuild.css')}}">

</head>
<body>

<div class="container shop-index">

    <div class="row">

        @foreach($products as $product)
            <div class="col-xs-6 col-md-4 col-lg-3">
                <a href="/web/detail?id={{$product->id}}">
                    <div class="thumbnail">
                        <img src="{{$product->logo}}" alt="">

                        <div class="caption">
                            <p>{{$product->name}}</p>

                            <p class="small">{{$product->remark}}</p>
                            <strong>&yen;{{$product->price}}</strong><span>/<small>{{intval($product->beans)}}迈豆</small>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>