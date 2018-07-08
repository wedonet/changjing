
@extends('admin.layout')


@section('content')
    <ol class="crumb clearfix">
        <li><a href="/adminconsole">控制台</a></li>
        <li class="active"> - 用户管理</li>
        <li><a href="/adminconsole/adminuser"> - 管理员</a></li>
        <li class="active"> - 编辑管理员</li>
    </ol>

    <div class="row page-title-row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
            <a href="/adminconsole/adminuser" class="btn btn-success btn-md addNewNav" type="button">
                返回上一层
            </a>
        </div>

    </div>
    <!-- Display Validation Errors -->
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">编辑管理员</div>
    </div>

    <div class="panel-body" >
    <div id="adminuseredit">
    <form method="POST" action="{{ url('adminconsole/adminuser') }}/{{ $vo->id }}" class="form-horizontal j_form adminiRegister" >
		{!! csrf_field() !!}

        <input type="hidden" name="pid" value="{{ $bizid->id }}">
        <input type="hidden" name="_method" value="put">
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">所属角色</label>
            <div class="col-md-2">
                <select name="u_rolename" id="" class="form-control">
                    <option name="u_rolename" value="{{ $vo->u_rolename }}" selected>{{ $vo->u_rolename }}</option>
                    @foreach($st as $v)
                        <option name="u_rolename">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <span class="red">*</span>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="name" >用户名</label>
            <div class="col-md-3">

                    <input type="text" placeholder=""  readonly class="form-control" name="u_name" value="{{ $vo->u_name }}" >

            </div>
            <span class="red">*</span><span>(4-20位数字、字母或其组合)</span>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">昵称</label>
            <div class="col-md-3">
                <input type="text" placeholder="" required="required" class="form-control" name="u_nick" value="{{ $vo->u_nick }}">
            </div>
            <span class="red">*</span><span>(2-20位!)</span>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="name">手机</label>
            <div class="col-md-3">
                <input type="text" placeholder=""  class="form-control" name="u_mobile" value="{{ $vo->u_mobile }}">
            </div>
            <span class="red">*</span><span>(只能为11位数字)</span>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">邮箱</label>
            <div class="col-md-3">
                <input type="text" placeholder=""  class="form-control" name="u_mail" value="{{ $vo->u_mail }}">
            </div>
            <span class="red">*</span><span>(只能为email格式)</span>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="submit"></label>
            <div class="col-md-3">
                <input type="submit" class="btn btn-info" value=" 提 交 " />
            </div>
        </div>
    </form>

    <form method="POST" action="{{ url('adminconsole/adminuser/editpassword') }}/{{ $vo->id }}" class="form-horizontal j_form adminiRegister">
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="{{ $vo->id }}">
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">密码</label>
            <div class="col-md-3">
                <input type="password" placeholder="" required="required" class="form-control" name="u_pass">
            </div>
            <span class="red">*</span><span>(6至20位数字与字母两种组合)</span>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">确认密码</label>
            <div class="col-md-3">
                <input type="password" placeholder="" required="required" class="form-control" name="u_passes">
            </div>
            <span class="red">*</span><span>(与密码一致)</span>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="submit"></label>
            <div class="col-md-3">
                <input type="submit" class="btn btn-info" value=" 提 交 " />
            </div>
        </div>
    </form>

    <form method="POST" action="{{ url('userAdmin/administrators/update') }}" class="form-horizontal j_form adminiRegister">
        {!! csrf_field() !!}
        <input type="hidden" name="oldname" value="{{ $vo->u_name }}">
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">口令</label>
            <div class="col-md-3">
                <input type="text" placeholder="" required="required" class="form-control" name="u_pass">
            </div>
            <span class="red">*</span><span>(6至20位)</span>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">确认口令</label>
            <div class="col-md-3">
                <input type="text" placeholder="" required="required" class="form-control" name="u_passses">
            </div>
            <span class="red">*</span><span>(与口令一致)</span>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="submit"></label>
            <div class="col-md-3">
                <input type="submit" class="btn btn-info" value=" 提 交 " />
            </div>
        </div>
    </form>
    </div>
    </div>
</div>
    {{--帮助中心--}}
    <div class="helpContent">
        <a class="foldBtn"><b class="glyphicon glyphicon-arrow-up"></b> <span>收起</span></a>
        <p><i class="glyphicon glyphicon-hand-right"></i> 操作提示 <i class="glyphicon glyphicon-hand-left"></i></p>
        <ol>
            <li>
                <dl>
                    <dt>口令是什么，有什么作用？</dt>
                    <dd>答：口令相当于管理员的第二层密码，只有密码和口令均正确后，管理员方可成功登录。</dd>
                </dl>
            </li>
        </ol>
    </div>
    {{--帮助中心--}}
@stop