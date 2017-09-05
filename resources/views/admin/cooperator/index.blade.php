@extends('.admin._layouts.common')
@section('title')
    接入列表
@stop
@section('main')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">接入管理</strong> /
                <small>第三方引流管理</small>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs empty-a">
                        <a href="/admin/cooperator/create" type="button" class="am-btn am-btn-success"><span
                                    class="am-icon-plus"></span>新增</a>
                    </div>
                </div>
            </div>
            <div class="am-u-sm-12 am-text-nowrap am-scrollable-horizontal">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-compact am-table-hover table-main">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>接入者名称</th>
                            <th>URL</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cooperators as $cooperator)
                            <tr>
                                <td>{{$cooperator->id}}</td>
                                <td>{{$cooperator->name}}</td>
                                <td>{{url('/shop/index?cooperator_id='). $cooperator->id}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
                            {{$cooperators->render() }}
                        </div>
                    </div>
                    <hr>
                </form>
            </div>
        </div>
    </div>
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
        };
    </script>
@stop

