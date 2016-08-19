@extends('.admin._layouts.common')
@section('title')
    修改管理员
@stop
@include('UEditor::head')
@section('main')
    <div class="admin-content" xmlns="http://www.w3.org/1999/html" style="height: auto">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">管理员管理</strong> /
                <small>修改管理员</small>
            </div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-10">
                <form class="am-form am-form-horizontal" method="post" action="/admin/user/{{$user->id}}"
                      enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="put"/>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">管理员名称</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="name" placeholder="管理员名称" name="name" value="{{$user->name}}"
                                   required>
                            <small></small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">管理员邮箱</label>

                        <div class="am-u-sm-9">
                            <input type="email" id="email" placeholder="管理员邮箱" name="email" value="{{$user->email}}"
                                   required>
                            <small></small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">密码</label>

                        <div class="am-u-sm-9">
                            <input type="password" id="password" placeholder="密码" name="password" value="">
                            <small></small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button type="submit" class="am-btn am-btn-primary">保存修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop