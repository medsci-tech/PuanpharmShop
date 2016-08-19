@extends('.admin._layouts.common')
@section('title')
    创建供应商信息
@stop
@section('main')
    <div class="admin-content" xmlns="http://www.w3.org/1999/html">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">供应商</strong> /
                <small>创建供应商</small>
            </div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-10">
                <form class="am-form am-form-horizontal" method="post" action="/admin/supplier">
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">供应商名称</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="supplier_name" placeholder="供应商" name="supplier_name" required>
                            <small>输入你的名字，让我们记住你。</small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-intro" class="am-u-sm-3 am-form-label">供应商简介</label>

                        <div class="am-u-sm-9">
                            <textarea class="" rows="5" id="supplier_desc" placeholder="输入个人简介"
                                      name="supplier_desc" required></textarea>
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