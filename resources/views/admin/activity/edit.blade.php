@extends('.admin._layouts.common')
@section('title')
    编辑活动信息
@stop
@section('main')
    <div class="admin-content" xmlns="http://www.w3.org/1999/html">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">活动</strong> /
                <small>编辑活动信息</small>
            </div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-10">
                <form class="am-form am-form-horizontal" method="post" action="/admin/activity/{{$activity->id}}">
                    <input type="hidden" name="_method" value="put"/>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">活动名称</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="activity_name" placeholder="活动名称" name="activity_name"
                                   value="{{$activity->activity_name}}" required>
                            <small>输入你的名字，让我们记住你。</small>
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