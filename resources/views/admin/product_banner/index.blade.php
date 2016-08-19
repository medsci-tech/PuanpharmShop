@extends('.admin._layouts.common')
@section('title')
    商品Banner图管理
@stop
@section('main')
    <div class="admin-content">

        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg">Banner</strong> /
                    <small>商品Banner图管理</small>
                </div>
            </div>

            <hr>

            <ul class="am-avg-sm-2 am-avg-md-4 am-avg-lg-6 am-margin gallery-list">
                @foreach($banners as $banner)
                    <li>
                        <a href="#">
                            <img class="am-img-thumbnail am-img-bdrs" src="{{$banner->image_url}}" alt="">

                            <div class="gallery-title">商品名称{{$banner->product? $banner->product->name : '-'}}</div>
                            <div class="gallery-desc">{{$banner->create_at}}</div>
                            <div class="am-btn-group am-btn-group-xs">
                                <a href="/admin/product-banner/{{$banner->id}}/edit"
                                   class="am-btn am-btn-xs am-btn-primary"><span
                                            class="am-icon-pencil"></span> Edit</a>
                                <a type="button" class="am-btn am-btn-danger"
                                   id="delete{{ $banner->id }}"><span class="am-icon-remove"></span>
                                    Delete</a>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="am-cf">
                <div class="am-fr">
                    {{$banners->render() }}
                </div>
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
        }

        $(function () {
            $('[id^=delete]').on('click', function () {
                $('.am-modal-bd').text('您确定要删除?');
                id = this.id.slice(6);
                $('#my-confirm').modal({
                    relatedTarget: this,
                    onConfirm: function (options) {
                        $.ajax({
                            url: '/admin/product-banner/' + id,
                            type: 'Delete',
                            dataType: 'text',
                            contentType: 'application/json',
                            async: true,
                            success: function (data) {
                                location.reload();
                            },
                            error: function (XMLResponse) {
                                console.log(XMLResponse.responseText);
                                alert(XMLResponse.responseText);
                            }
                        });
                    },
                    onCancel: function () {
                    }
                });
            });
        });
    </script>
@stop
