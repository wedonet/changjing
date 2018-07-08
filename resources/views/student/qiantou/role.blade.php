

@extends('admin.layout')


@section('content')
<ol class="breadcrumb">
    <li><a href="/adminconsole">控制台</a></li>
    <li class="active">用户管理</li>
    <li><a href="/adminconsole/usergroup">用户组</a></li>
    <li class="active">角色</li>
</ol>
<div class="row page-title-row" >
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-right" >
        <a href="/adminconsole/usergroup" class="btn btn-success btn-md addNewNav" type="button">
            返回上一层
        </a>
        <a href="/adminconsole/usergroup/roleCreate" class="btn btn-success btn-md" type="button" onclick="getRoleId(this)">
            添加角色
        </a>
    </div>

</div>



<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
        <tr>
            <th width="5%" >#</th>
            <th width="15%">角色名称</th>
            <th width="15%">角色 ( IC )</th>
            <th width="10%">会员数</th>
            <th width="10%">
                <div class="btn-group userSort">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">排序<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/adminconsole/usergroup/usergroupRole/{{ $pid  }}?sort=1">正序</a></li>
                        <li><a href="/adminconsole/usergroup/usergroupRole/{{ $pid  }}?sort=0">倒序</a></li>
                    </ul>
                </div>
            </th>
            <th width="10%">使用</th>
            <th width="35%">操作</th>
        </tr>
        </thead>
        @foreach ($userrole as $v)
            <tr>
                <td>{{ $v->id }}</td>
                <td>{{ $v->title }}</td>
                <td>{{ $v->ic }}</td>
                <td>{{ $v->counters }}</td>
                <td>{{ $v->cls }}</td>
                <td>
                    {{ $v->isuse }}
                </td>
                <td>

                <a href="/adminconsole/usergroup/roleEdit/{{ $v->id }}" class="btn btn-xs btn-warning" title="">
                    <i class="glyphicon glyphicon-cog"></i> 编辑
                </a>
                    {!! $v->a !!}
            </td>
        </tr>
        @endforeach
    </table>
</div>
@include('admin.partials._modals')
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $('a.j_del').on('click', function () {
                $("#modal_text").html($(this).attr('title'));
                $("#delaction").attr('action', ($(this).attr('href')));
                $("#modal-delete").modal("show");
                return false;
            })
        })



        // Confirm folder delete
        function delete_folder(name) {
            $("#delete-folder-name1").html(name);
            $("#delete-folder-name2").val(name);
            $("#modal-folder-delete").modal("show");
        }

        // Preview image
        function preview_image(path) {
            $("#preview-image").attr("src", path);
            $("#modal-image-view").modal("show");
        }

    </script>
@stop