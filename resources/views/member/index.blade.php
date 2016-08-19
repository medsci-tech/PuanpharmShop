<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>普安易康</title>
    <link rel="stylesheet" href="{{asset('/member/css/swiper-3.3.0.min.css')}}">
    <link rel="stylesheet" href="{{asset('/member/css/shop_rebuild.css')}}">

</head>
<body>

<div class="container shop-index">

    <div class="row">

        @foreach($products as $product)
            <div class="col-xs-6 col-md-4 col-lg-3">
                <a href="/member/detail?id={{$product->id}}">
                    <div class="thumbnail">
                        <img src="{{$product->logo}}" alt="">

                        <div class="caption">
                            <p style="height: 22px;overflow:hidden">{{$product->name}}</p>
                            <strong>{{intval($product->beans)}}糖豆</strong>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>