@extends('.admin._layouts.common')
@section('title')
    创建管理员
@stop
@include('UEditor::head')
@section('main')
    <div class="admin-content" xmlns="http://www.w3.org/1999/html" style="height: auto">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">管理员管理</strong> /
                <small>创建管理员</small>
            </div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-10">
                <form class="am-form am-form-horizontal" method="post" action="/admin/user"
                      enctype="multipart/form-data">
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">管理员名称</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="name" placeholder="管理员名称" name="name" required>
                            <small></small>
                        </div>
                    </div>


                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">管理员邮箱</label>

                        <div class="am-u-sm-9">
                            <input type="email" id="email" placeholder="管理员邮箱" name="email" required>
                            <small></small>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">密码</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="email" placeholder="密码" name="password" required>
                            <small></small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button type="submit" class="am-btn am-btn-primary">创建管理员</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop