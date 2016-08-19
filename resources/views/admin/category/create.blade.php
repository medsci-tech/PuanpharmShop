@extends('.admin._layouts.common')
@section('title')
    创建分类
@stop
@section('main')
    <div class="admin-content" xmlns="http://www.w3.org/1999/html">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">产品类型</strong> /
                <small>创建产品类型</small>
            </div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-10">
                <form class="am-form am-form-horizontal" method="post" action="/admin/category"
                      enctype="multipart/form-data">
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">类型名称</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="name" placeholder="分类名称" name="name" required>
                            <small>输入你的名字，让我们记住你。</small>
                        </div>
                    </div>

                    <div class="am-form-group am-form-file">
                        <label for="doc-ipt-file-2" class="am-u-sm-3 am-form-label">类型图片</label>

                        <div class="am-u-sm-9">
                            <button type="button" class="am-btn am-btn-default am-btn-sm"><i
                                        class="am-icon-cloud-upload"></i> 选择要上传的文件
                            </button>
                        </div>
                        <input type="file" name="logo">
                    </div>

                    {{--<div class="am-form-group am-form-select">--}}
                    {{--<label for="doc-select-1" class="am-u-sm-3 am-form-label">所属类型</label>--}}

                    {{--<div class="am-u-sm-9">--}}
                    {{--<select id="doc-select-1" name="category_id">--}}
                    {{--<option value="">===请选择===</option>--}}
                    {{--</select>--}}
                    {{--<span class="am-form-caret"></span>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="am-form-group">
                        <label for="user-intro" class="am-u-sm-3 am-form-label">类型简介</label>

                        <div class="am-u-sm-9">
                            <textarea class="" rows="5" id="user-intro" placeholder="输入个人简介"
                                      name="description"></textarea>
                            <small>250字以内写出你的一生...</small>
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