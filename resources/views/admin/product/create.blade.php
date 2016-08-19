@extends('.admin._layouts.common')
@section('title')
    创建商品
@stop
@include('UEditor::head')
@section('main')
    <div class="admin-content" xmlns="http://www.w3.org/1999/html" style="height: auto">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">商品管理</strong> /
                <small>创建商品</small>
            </div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-10">
                <form class="am-form am-form-horizontal" method="post" action="/admin/product"
                      enctype="multipart/form-data">
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">商品名称</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="name" placeholder="商品名称" name="name" required>
                            <small></small>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="weight" class="am-u-sm-3 am-form-label">商品权重</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="weight" placeholder="商品权重" name="weight" value="0">
                            <small>权重越大,排序越靠前</small>
                        </div>
                    </div>
                    <div class="am-form-group am-form-select">
                        <label for="doc-select-1" class="am-u-sm-3 am-form-label">所属分类</label>
                        <div class="am-u-sm-9">
                            <select id="" name="category_id" required>
                                <option value="">==请选择分类==</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <span class="am-form-caret"> </span>
                        </div>
                    </div>

                    <div class="am-form-group am-form-select">
                        <label for="doc-select-1" class="am-u-sm-3 am-form-label">所属活动</label>

                        <div class="am-u-sm-9">
                            <select id="activity_id" name="activity_id">
                                <option value="">==请选择所属活动==</option>
                                @foreach($activities as $activity)
                                    <option value="{{$activity->id}}">{{$activity->activity_name}}</option>
                                @endforeach
                            </select>
                            <span class="am-form-caret"> </span>
                        </div>
                    </div>

                    <div class="am-form-group am-form-select">
                        <label for="doc-select-1" class="am-u-sm-3 am-form-label">所属供应商</label>

                        <div class="am-u-sm-9">
                            <select id="" name="supplier_id" required>
                                <option value="">==请选择供应商==</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                @endforeach
                            </select>
                            <span class="am-form-caret"> </span>
                        </div>
                    </div>

                    <div class="am-form-group am-form-select">
                        <label for="doc-select-1" class="am-u-sm-3 am-form-label">是否出售</label>

                        <div class="am-u-sm-9">
                            <select id="" name="is_on_sale">
                                <option value="1">出售</option>
                                <option value="0">不出售</option>
                            </select>
                            <span class="am-form-caret"> </span>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="specifications" class="am-u-sm-3 am-form-label">默认规格</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="default_spec" placeholder="商品规格" name="default_spec" required>
                            <small></small>
                        </div>
                    </div>

                    <div class="am-form-group" id="price">
                        <label for="price" class="am-u-sm-3 am-form-label">商品价格</label>

                        <div class="am-u-sm-6">
                            <input type="text" id="price" placeholder="商品价格" name="price" required>
                            <small></small>
                        </div>

                        <div class="am-u-sm-3" id="add_spec">
                            <button type="button" class="am-btn am-btn-success" id="add-spec">
                                <span class="am-icon-plus"></span>添加规格
                            </button>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="beans" class="am-u-sm-3 am-form-label">迈豆价格</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="price" placeholder="迈豆价格" name="beans" required>
                            <small></small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">商品描述</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="price" placeholder="商品描述" name="description" required>
                            <small></small>
                        </div>
                    </div>

                    <div class="am-form-group am-form-file">
                        <label for="doc-ipt-file-2" class="am-u-sm-3 am-form-label">LOGO</label>

                        <div class="am-u-sm-9">
                            <input type="text" readonly="true" name="file_name" style="display: none;">
                            <button type="button" class="am-btn am-btn-default am-btn-sm" id="file_name"><i
                                        class="am-icon-cloud-upload"></i> 选择要上传的文件
                            </button>
                        </div>
                        <input type="file" id="doc-ipt-file-2" name="logo" required>
                    </div>

                    <div class="am-form-group am-form-file" id="banner">
                        <label for="doc-ipt-file-2" class="am-u-sm-3 am-form-label">ADD Banner</label>

                        <div class="am-u-sm-1" id="add-banner" style="float: left">
                            <button type="button" class="am-btn am-btn-success" id="add-spec">
                                <span class="am-icon-plus"></span>BANNER
                            </button>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">商品标签</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="tags" placeholder="标签" name="tags">
                            <small>请用","隔开。例:"药械,糖尿病"</small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-intro" class="am-u-sm-3 am-form-label">商品简介</label>

                        <div class="am-u-sm-9">
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="detail" type="text/plain">

                            </script>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button type="submit" class="am-btn am-btn-primary">创建商品</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="/admin/js/jquery.min.js"></script>
    <script type="text/javascript">
        $('#add-spec').click(function () {
            var input = '<div class="am-form-group"><label for="user-name" class="am-u-sm-3 am-form-label">商品规格</label><div class="am-u-sm-4"><input type="text" placeholder="规格名称,例如[100g]" name="spec_name[]" required></div><div class="am-u-sm-4"><input type="text"  placeholder="规格对应价格商品价格" name="spec_price[]" required></div></div>';
            $('#price').after(input);
        });

        $('#add-banner').click(function () {
            var banner = '<div class="am-form-group am-form-file"><label for="doc-ipt-file-2" class="am-u-sm-3 am-form-label">Banner</label><div class="am-u-sm-9"><input type="text" readonly="true" name="file_name" style="display: none;"><button type="button" class="am-btn am-btn-default am-btn-sm" id="file_name"><i class="am-icon-cloud-upload"></i> 选择要上传的文件</button></div><input type="file" name="banner[]" required></div>';
            $('#banner').after(banner);

            $('input[type=file]').change(function () {
                console.log($(this).parent().parent());
                var $parent = $(this).parent();
                console.log($parent.find('.am-btn-default'));
                $parent.find('.am-btn-default').css('display', 'none');
                $parent.find('input[name=file_name]').css('display', 'block');
                $parent.find('input[name=file_name]').val($(this).val());
            });
        });

        $('input[type=file]').change(function () {
            console.log($(this).parent().parent());
            var $parent = $(this).parent();
            console.log($parent.find('.am-btn-default'));
            $parent.find('.am-btn-default').css('display', 'none');
            $parent.find('input[name=file_name]').css('display', 'block');
            $parent.find('input[name=file_name]').val($(this).val());
        });
        <!-- 实例化编辑器 -->
        var ue = UE.getEditor('container');
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        });
    </script>
@stop