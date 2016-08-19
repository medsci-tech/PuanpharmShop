<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Login Page</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <link rel="alternate icon" type="image/png" href="/i/favicon.png">
    <link rel="stylesheet" href="{{ asset('/admin/css/amazeui.min.css') }}"/>
    <style>
        .header {
            text-align: center;
        }

        .header h1 {
            font-size: 200%;
            color: #333333;
            margin-top: 30px;
        }

        .header p {
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="am-g">
        <h1>LOGIN</h1>
    </div>
    <hr>
</div>
<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        @if (Session::has('message'))
            <div class="am-alert am-alert-{{ Session::get('message')['type'] }}" data-am-alert>
                <p>{{ Session::get('message')['content'] }}</p>
            </div>
        @endif
        @if ($errors->has())
            <div class="am-alert am-alert-danger" data-am-alert>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif
        <form method="post" class="am-form" action="/admin/login">
            <label for="email">邮箱:</label>
            <input type="email" name="email" id="email" value="" required>
            <br>
            <label for="password">密码:</label>
            <input type="password" name="password" id="password" value="" required>
            <br>
            <button type="submit" class="am-btn am-btn-primary am-btn-block">登陆</button>
        </form>
        <hr>
    </div>
</div>


<div id="cntvlive2-is-installed"></div>
</body>
</html>