<!doctype html>
<html >
<head>
    <meta charset="UTF-8">
    <title>商城</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/swiper.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
	
</head>

<body class="index" >
<!--提示框-->
222222222222
<!---end-->
<header>
    
</header>
<main class="content">

</main>

<nav class="footer">

</nav>


</div>
<div class="notify">
    <p class="notify-inner">添加购物车成功</p>
</div>
<script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
<script type="text/javascript" src="/shop/js/libs/swiper.jquery.min.js"></script>
<script type="text/javascript" src="/shop/js/components.js"></script>
<script type="text/javascript" src="/shop/js/libs/jquery.pep.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
{{--<script type="text/javascript" src="/shop/js/main.js"></script>--}}
<script>
    $(function () {
		$('.noticeBtn').on('click', function () {
            $('.noticeBox').hide();
			$('.noticeBg').hide();
        });
        $('nav .menu').on('click', function (event) {
            $(this).find('.sub-menu').toggle();
            $(this).siblings().find('.sub-menu').fadeOut();

            event.stopPropagation();
        });

        $(document.body).on('click', function () {
            $('.sub-menu').fadeOut();
        });

        if (typeof Swiper !== 'function') {
            return;
        }
        var swiperConfig = {
            pagination: '.swiper-pagination',
            loop: true,
            autoplay: 3000
        };
        var swiper = new Swiper('.swiper-container', swiperConfig);

        function reInitSwiper() {
            setTimeout(function () {
                swiper.destroy(true, true);
                swiper = new Swiper('.swiper-container', swiperConfig);
            }, 500);
        }


        $(window).resize(function () {
            reInitSwiper();
        });


        $(window).on('orientationchange', function () {
            reInitSwiper();
        });
		 
		
		
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
