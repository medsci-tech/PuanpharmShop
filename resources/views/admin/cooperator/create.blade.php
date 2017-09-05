@extends('.admin._layouts.common')
@section('title')
    新增接入者
@stop
@section('main')
    <div class="admin-content" xmlns="http://www.w3.org/1999/html">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">接入者</strong> /
                <small>新增接入者</small>
            </div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-10">
                <form class="am-form am-form-horizontal" method="post" action="/admin/cooperator">
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">接入者名称</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="supplier_name" placeholder="接入者" name="name" required>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button type="submit" class="am-btn am-btn-primary">创建</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop