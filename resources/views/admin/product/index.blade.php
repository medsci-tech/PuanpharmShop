@extends('.admin._layouts.common')
@section('title')
    商品列表
@stop
@section('main')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">商品管理</strong> /
                <small>商品列表</small>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs empty-a">
                        <a href="/admin/product/create" type="button" class="am-btn am-btn-success"><span
                                    class="am-icon-plus"></span>新增</a>
                    </div>
                </div>
            </div>
            {{--<form class="am-form am-form-horizontal" method="post" action="/admin/update-puan-id"--}}
                  {{--enctype="multipart/form-data">--}}
                {{--<input type="file" name="excel" required>--}}
                {{--<button type="submit">提交</button>--}}
            {{--</form>--}}

            <div class="am-u-sm-12 am-u-md-3">

                <select id="sort" class="am-form-field">
                    <option value="id">ID</option>
                    <option value="price">价格</option>
                    <option value="weight">权重</option>
                </select>

            </div>

            <div class="am-u-sm-12 am-u-md-3">
                <form action="/admin/product/search" method="post">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" name="keyword" class="am-form-field" placeholder="请输入商品名称，tag或描述">
                         <span class="am-input-group-btn">
                        <button class="am-btn am-btn-default" type="submit">搜索</button>
                       </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-id">ID</th>
                            <th class="table-title">商品名称</th>
                            <th class="table-type">所属类别</th>
                            <th class="table-type">供应商</th>
                            <th class="table-type">活动</th>
                            <th class="table-type">状态</th>
                            <th class="table-author">价格</th>
                            <th class="table-author">默认规格</th>
                            <th class="table-author">权重</th>
                            <th class="table-author am-hide-sm-only">创建时间</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->name}}</td>
                                <td>{!!  $product->category ? '<a href="/admin/product?category_id='.$product->category->id.'">'.$product->category->name.'</a>' : '未选择分类'!!}</td>
                                <td>{{$product->supplier ?$product->supplier->supplier_name : '未选择供应商'}}</td>
                                <td><a href="#">{{$product->activity ?$product->activity->activity_name : '暂未参加活动'}}</a>
                                </td>
                                {{--<td>{!!  $product->activity ? '<a href="/admin/product?activity_id='.$product->activity->id.'">'.$product->activity->activity_name.'</a>' : '暂未参加活动'!!}</td>--}}
                                <td>{{$product->is_on_sale ?'出售' : '不出售'}}</td>
                                <td class="am-hide-sm-only">{{$product->price}}</td>
                                <td class="am-hide-sm-only">{{$product->default_spec}}</td>
                                <td class="am-hide-sm-only">{{$product->weight}}</td>
                                <td class="am-hide-sm-only">{{$product->created_at}}</td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a href="/admin/product/{{$product->id}}/edit"
                                               class="am-btn am-btn-xs am-btn-primary"><span
                                                        class="am-icon-pencil"></span> 修改</a>
                                            <a type="button" class="am-btn am-btn-danger"
                                               id="delete{{ $product->id }}"><span class="am-icon-remove"></span>
                                                删除</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
                            @if(isset($category_id))
                                {{$products->appends(['sort' => $sort, 'category_id' => $category_id])->render() }}
                            @else
                                {{$products->appends(['sort' => $sort])->render() }}
                            @endif

                        </div>
                    </div>
                    <hr>
                </form>
            </div>
        </div>
    </div>
    <div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
        <div class="am-modal-dialog">
            <div class="am-modal-bd">
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-confirm>是</span>
                <span class="am-modal-btn" data-am-modal-cancel>否</span>
            </div>
        </div>
    </div>
    <script src="/admin/js/jquery.min.js"></script>
    <script type="text/javascript" language="javascript">
        window.onload = function () {
            paginations = document.getElementsByClassName('pagination');
            paginations[0].className = 'am-pagination';
            disabled = document.getElementsByClassName('disabled');
            if (disabled[0]) {
                disabled[0].className = 'am-disabled';
            }
            paginations = document.getElementsByClassName('active');
            paginations[0].className = 'am-active';
            $('#sort').val('{{$sort}}');
        };

        $(function () {

            $.extend({
                Request: function (m) {
                    var sValue = location.search.match(new RegExp("[\?\&]" + m + "=([^\&]*)(\&?)", "i"));
                    return sValue ? sValue[1] : sValue;
                },
                UrlUpdateParams: function (url, name, value) {
                    var r = url;
                    if (r != null && r != 'undefined' && r != "") {
                        value = encodeURIComponent(value);
                        var reg = new RegExp("(^|)" + name + "=([^&]*)(|$)");
                        var tmp = name + "=" + value;
                        if (url.match(reg) != null) {
                            r = url.replace(eval(reg), tmp);
                        }
                        else {
                            if (url.match("[\?]")) {
                                r = url + "&" + tmp;
                            } else {
                                r = url + "?" + tmp;
                            }
                        }
                    }
                    return r;
                }


            });

            $('[id^=delete]').on('click', function () {
                $('.am-modal-bd').text('您确定要删除?');
                id = this.id.slice(6);
                $('#my-confirm').modal({
                    relatedTarget: this,
                    onConfirm: function (options) {
                        $.ajax({
                            url: '/admin/product/' + id,
                            type: 'Delete',
                            dataType: 'text',
                            contentType: 'application/json',
                            async: true,
                            success: function (data) {
                                location.reload();
                            },
                            error: function (XMLResponse) {
                                alert(XMLResponse.responseText);
                            }
                        });
                    },
                    onCancel: function () {
                    }
                });
            });

            $('#sort').change(function () {
                window.location.href = $.UrlUpdateParams(window.location.href, "sort", $(this).val());
            });
        });
    </script>
@stop
