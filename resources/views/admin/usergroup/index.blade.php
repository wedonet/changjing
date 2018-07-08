{{-- admin/usergroup --}}
@extends('admin.layout')


@section('content')

<ol class="crumb clearfix">
    <li><a href="/adminconsole">控制台</a></li>
    <li class="active"> - 用户管理</li>
    <li class="active"> - 用户组</li>
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-right" >
        <a href="/adminconsole/usergroup/create" class="btn btn-success btn-md" type="button">
             新建用户组
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="j_list" >
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">用户组名称</th>
                <th width="15%">识别码 ( IC )</th>
                <th width="10%">会员数</th>
                <th width="10%">

                    <div class="btn-group userSort">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">排序<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/adminconsole/usergroup?sort=1" >正序</a></li>
                            <li><a href="/adminconsole/usergroup?sort=0" >倒序</a></li>
                        </ul>
                    </div>
                </th>
                <th width="10%">使用</th>
                <th width="20%">操作</th>
            </tr>
        </thead>
    @foreach($usergroups as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->title }}</td>
            <td>{{ $user->ic }}</td>
            <td>{{ $user->counters }}</td>
            <td>{{ $user->cls }}</td>
            <td>{{ $user->isuse }}</td>
            <td>
                <a href="/adminconsole/usergroup/{{ $user->id  }}/edit" class="btn btn-xs btn-warning" title="">
                    <i class="glyphicon glyphicon-cog"></i> 编辑
                </a>
                <a href="/adminconsole/usergroup/usergroupRole" class="btn btn-xs btn-info" onclick="getId(this)" title="{{ $user->title}}">
                    <i class="glyphicon glyphicon-user"></i> 角色
                </a>
                {!! $user->a !!}
            </td>
        </tr>
    @endforeach

    </table>
</div>
{{-- $usergroups->render() --}}






@include('admin.partials._modals')

{{--帮助中心--}}
<div class="helpContent">
    <a class="foldBtn"><b class="glyphicon glyphicon-arrow-up"></b> <span>收起</span></a>
    <p><i class="glyphicon glyphicon-hand-right"></i> 操作提示 <i class="glyphicon glyphicon-hand-left"></i></p>
    <ol>
        <li>
            <dl>
                <dt>什么是角色？</dt>
                <dd>答：角色为此用户组下设的所有岗位，如公司有管理员、有员工等。</dd>
            </dl>
        </li>
    </ol>
</div>
{{--帮助中心--}}
@stop


{{--@section('scripts')--}}
{{--<script>--}}
    {{--$(document).ready(function () {--}}
        {{--$('a.j_del').on('click', function () {--}}
            {{--$("#modal_text").html($(this).attr('title'));--}}
            {{--$("#delaction").attr('action', ($(this).attr('href')));--}}
            {{--$("#modal-delete").modal("show");--}}
            {{--return false;--}}
        {{--})--}}
    {{--})--}}


    {{--// Confirm folder delete--}}
    {{--function delete_folder(name) {--}}
        {{--$("#delete-folder-name1").html(name);--}}
        {{--$("#delete-folder-name2").val(name);--}}
        {{--$("#modal-folder-delete").modal("show");--}}
    {{--}--}}

    {{--// Preview image--}}
    {{--function preview_image(path) {--}}
        {{--$("#preview-image").attr("src", path);--}}
        {{--$("#modal-image-view").modal("show");--}}
    {{--}--}}
    {{--//获取ID--}}
    {{--function getId(obj){--}}
        {{--var id=--}}
                {{--$(obj).parent().parent().find('td:first').html();--}}
        {{--var href=$(obj).attr('href')+'/'+id;--}}
        {{--$(obj).attr('href',href);--}}

    {{--}--}}

{{--</script>--}}
{{--@stop--}} 