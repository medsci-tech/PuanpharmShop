<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>我的迈豆</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <link rel="stylesheet" href="{{ asset('/shop/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/shop/css/style.css') }}"/>
</head>
@if($logs)
    <body class="beans">
    <main class="content">
        <div class="shop-list">
            @foreach($months as $month)
                @if($month == $now)
                    <div class="header" style="background-color: #e5e5e5;width: 100%" onclick="showList({{$month}})">
                        <a href="#" class="beans"><strong>本月</strong></a>
                    </div>
                    @foreach($logs as $log)
                        @if(date ('Y-m', strtotime($log->created_at)) == $month)
                            <div class="cart-list" style="border-bottom: 0.03125rem solid #e5e5e5;width: 100%;" id="list-{{$month}}">
                                <div class="cart-item">
                                    <div class="bean-date">
                                        <p class="date">{{date ('m-d', strtotime($log->created_at))}}</p>

                                        <p class="time">{{date ('h:m', strtotime($log->created_at))}}</p>
                                    </div>
                                    <div class="bean-detail" style="padding-left: 1.2rem">
                                        <p class="count">{{$log->result}}</p>

                                        <p class="location">{{$log->rate->action_ch}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="header" style="background-color: #e5e5e5;" onclick="showList({{$month}})">
                        <a href="#" class="beans"><strong>{{$month}}</strong></a>
                    </div>

                    @foreach($logs as $log)
                        @if(date ('Y-m', strtotime($log->created_at)) == $month)
                            <div class="cart-list" style="border-bottom: 0.03125rem solid #e5e5e5;width: 100%;display: none;" id="list-{{$month}}">
                                <div class="cart-item">
                                    <div class="bean-date">
                                        <p class="date">{{date ('m-d', strtotime($log->created_at))}}</p>

                                        <p class="time">{{date ('h:m', strtotime($log->created_at))}}</p>
                                    </div>
                                    <div class="bean-detail" style="padding-left: 1.2rem">
                                        <p class="count">{{$log->result}}</p>

                                        <p class="location">{{$log->rate->action_ch}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>
    </main>
    <script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
    <script type="text/javascript" src="/shop/js/components.js"></script>
    <script type="text/javascript" src="/shop/js/main.js"></script>
    <script type="text/javascript">
        function showList(month) {
            $("#list-"+month).css({display: 'block'});
            $('[id^=list-]').css({display: 'none'});
        }
    </script>
    </body>
@else
    <body class="empty">
    <main class="content">
        <div class="empty-list " style="padding-top:60px;">
            <!-- 文本 -->
            <div class="empty-list-header">
                <h4>您暂时还没有积分入账</h4>
                <span>快给我挑点宝贝</span>
            </div>
            <!-- 自定义html，和上面的可以并存 -->
            <div class="empty-list-content">
                <a href="/shop/index" class="empty-btn">去逛逛</a>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="/shop/js/libs/jquery.min.js"></script>
    <script type="text/javascript" src="/shop/js/libs/flexible.js"></script>
    <script type="text/javascript" src="/shop/js/components.js"></script>
    <script type="text/javascript" src="/shop/js/main.js"></script>
    </body>
@endif
</html>
