<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>普安易康</title>
    <link rel="stylesheet" href="{{asset('/member/css/shop_rebuild.css')}}">
</head>
<body>

<div class="container shop-index">
    <div class="row">
        @foreach($products as $product)
            <div class="col-xs-6 col-md-4 col-lg-3">
                <a href="/wx/detail?id={{$product->id}}">
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
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="/shop/js/libs/jquery.pep.js"></script>
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