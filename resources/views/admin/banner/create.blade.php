@extends('.admin._layouts.common')
@section('title')
    新建首页banner图
@stop
@include('UEditor::head')
@section('main')
    <div class="admin-content" xmlns="http://www.w3.org/1999/html" style="height: auto">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页banner图管理</strong> /
                <small>新建首页banner图</small>
            </div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-10">
                <form class="am-form am-form-horizontal" method="post"
                      action="/admin/banner"
                      enctype="multipart/form-data">

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">banner权重</label>

                        <div class="am-u-sm-9">
                            <input type="text" placeholder="banner权重" name="weight" value="0" required>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="baby" class="am-u-sm-3 am-form-label">是否是奶粉banner</label>

                        <div class="am-u-sm-9">
                            <input id="baby" type="checkbox" value="1" name="baby">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">banner 链接</label>

                        <div class="am-u-sm-9">
                            <input type="url" placeholder="banner链接" name="href_url">
                        </div>
                    </div>

                    <div class="am-form-group am-form-file">
                        <label for="doc-ipt-file-2" class="am-u-sm-3 am-form-label">Image</label>

                        <div class="am-u-sm-9">
                            <input type="text" readonly="true" name="file_name" style="display: none;">
                            <button type="button" class="am-btn am-btn-default am-btn-sm" id="file_name"><i
                                        class="am-icon-cloud-upload"></i> 选择要上传的文件
                            </button>
                        </div>
                        <input type="file" id="doc-ipt-file-2" name="banner" required>
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
    <script src="/admin/js/jquery.min.js"></script>
    <script type="text/javascript" language="javascript">
        $('input[type=file]').change(function () {
            console.log($(this).parent().parent());
            var $parent = $(this).parent();
            console.log($parent.find('.am-btn-default'));
            $parent.find('.am-btn-default').css('display', 'none');
            $parent.find('input[name=file_name]').css('display', 'block');
            $parent.find('input[name=file_name]').val($(this).val());
        });
    </script>
@stop