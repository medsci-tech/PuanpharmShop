@extends('.admin._layouts.common')
@section('title')
    修改商品规格
@stop
@include('UEditor::head')
@section('main')
    <div class="admin-content" xmlns="http://www.w3.org/1999/html" style="height: auto">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">商品规格管理</strong> /
                <small>修改商品规格</small>
            </div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-10">
                <form class="am-form am-form-horizontal" method="post"
                      action="/admin/specification/{{$specification->id}}"
                      enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="put"/>
                    @if($specification->product)
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">所属商品</label>

                            <div class="am-u-sm-9">
                                <input type="text" id="specification_name" placeholder="label" name="product_name"
                                       value="{{$specification->product->name}}" readonly
                                       required>
                                <small></small>
                            </div>
                        </div>
                    @endif
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">商品规格名称</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="specification_name" placeholder="规格名称" name="specification_name"
                                   value="{{$specification->specification_name}}"
                                   required>
                            <small></small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">规格价格</label>

                        <div class="am-u-sm-9">
                            <input type="text" id="specification_price" placeholder="规格价格" name="specification_price"
                                   value="{{$specification->specification_price}}"
                                   required>
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