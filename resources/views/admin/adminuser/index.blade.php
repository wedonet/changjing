{{-- admin/adminuser --}}
@extends('admin.layout')


@section('content')


<ol class="crumb clearfix">
    <li><a href="/adminconsole" >控制台</a></li>
    <li class="active"> - 用户管理</li>
    <li class="active"> - 管理员</li>
</ol>

<div class="row page-title-row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-right">
        <a href="adminuser/create" class="btn btn-success btn-md" type="button">
            <i class="fa fa-plus-circle"></i> 新建管理员
        </a>

    </div>

</div>

<div class="table-responsive">
   
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">用户名</th>
                <th width="15%">昵称</th>
                <th width="10%">所属角色</th>
                <th width="10%">审核通过</th>
                <th width="10%">是否锁定</th>
                <th width="20%">操作</th>
            </tr>
        </thead>

        @foreach($list as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->u_name}}</td>
            <td>{{$v->u_nick}}</td>
            <td>{{$v->u_rolename}}</td>
            @if($v->ischeckd == 1)
            <td>yes</td>
                @if($v->islocked == 1)
                    <td>yes</td>
                    @else
                    <td>no</td>
                @endif
             @else
                <td>no</td>
                <td>暂无</td>
           @endif
            <td style="position:relative">


                <a href="{{ url('adminconsole/adminuser') }}/{{ $v->id }}/edit" class="btn btn-xs btn-warning " title="" >
                    <i class="glyphicon glyphicon-cog"></i> 编辑
                </a>
                <div class="adminPopup">
                    <a  href="javascript:;" class="btn btn-xs btn-danger adminChoose"  >
                        <i class="glyphicon glyphicon-folder-close"></i> 管理
                    </a>
                    <div class="showyes" style="display:none">
                        <form action="{{ url('/adminconsole') }}/{{ $v->id }}" method="post" >
                            {!! csrf_field() !!}
                            <div class="radio">
                                <div class="sh">
                                    是否通过审核：　
                                    <label>
                                        <input type="radio" name="optionsRadios"  id="" value="1">
                                        yes
                                    </label>
                                    <label>
                                        <input type="radio" name="optionsRadios" id="" value="0">
                                        no
                                    </label>
                                </div>
                                <div class="sd">
                                    是否锁定：　
                                    <label>
                                        <input type="radio" name="optionsRadioss"  id=""  value="1">
                                        yes
                                    </label>
                                    <label>
                                        <input type="radio" name="optionsRadioss" id="" value="0">
                                        no
                                    </label>
                                </div>
                            </div>
                            <p class="divider"></p>
                            <input type="submit" class="btn btn-success btn-sm submit" value="提交"/>
                        </form>
                        <em>&#9670;</em>
                        <span>&#9670;</span>
                    </div>
                </div>
                @if($v->u_name=='wedonet')
                @else
                    <a href="{{ url('/adminconsole/adminuser/adminuserss/') }}/{{ $v->id }}" class="btn btn-xs btn-link j_del" data-title1="用户名"  data-title2="{{$v->u_name}}" data-title3="管理员">
                        <i class="glyphicon glyphicon-trash"></i> 删除
                    </a>
                @endif

            </td>
        </tr>
        @endforeach
    </table>


    <div class="container">
        @foreach($list as $user)
            {{ $user->name }}
        @endforeach
    </div>
   <center>{!! $list->render() !!}</center>

</div>

@include('admin.partials._modals')
{{--帮助中心--}}
<div class="helpContent">
    <a class="foldBtn"><b class="glyphicon glyphicon-arrow-up"></b> <span>收起</span></a>
    <p><i class="glyphicon glyphicon-hand-right"></i> 操作提示 <i class="glyphicon glyphicon-hand-left"></i></p>
    <ol>
        <li>
            <dl>
                <dt>这些人员有哪些作用？</dt>
                <dd>答：此页面中的所有人员即为身份是管理员用户组的会员，审核通过且为锁定的会员可根据自己的用户名、密码和口令登录网站管理员后台。</dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>审核与锁定有什么不同，在哪里可以更改？</dt>
                <dd>答：新注册会员都需接受审核，审核通过后正式成为平台会员；只有成为正式的平台会员后方可进行锁定操作，通过锁定操作调整其使用状态，只有通过审核且未锁定的会员方可登录平台，
                    点击会员后的‘管理’按键，即可进行审核和锁定的修改。</dd>
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

    {{--</script>--}}
{{--@stop--}}