@extends('admin.layout')


@section('content')
<ol class="crumb clearfix">
    <li><a href="/adminconsole">控制台</a></li>
    <li class="active"> - 用户管理</li>
    <li><a href="/adminconsole/usergroup"> - 用户组</a></li>
    <li><a href="/adminconsole/usergroup/usergroupRole/{{ $id }}"> - 角色</a></li>
    <li class="active"> - 新建角色</li>
</ol>


<div class="row page-title-row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-right">
        <a href="/adminconsole/usergroup/usergroupRole/{{ $id }}" class="btn btn-success btn-md addNewNav" type="button">
            返回上一层
        </a>
    </div>

</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">新建角色</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="/adminconsole/usergroup/roleCreateR" class="form-horizontal j_form bizerRegister"  role="form">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-md-4 control-label" for="name">角色名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="名称" required="required" class="form-control" name="title" value="">
                </div>
                <span class="red">*</span><span>(类型限制:数字、字母和中文，长度不限)</span>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="name">角色( IC )</label>
                <div class="col-md-3">
                    <input type="text" placeholder="唯一标识" required="required" class="form-control" name="ic">
                </div>
                <span class="red">*</span><span>(2-20位数字、字母或其组合)注：新建之后不可修改</span>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="name">排序( 数字 )</label>
                <div class="col-md-3">
                    <input type="text" placeholder="数字" required="required" class="numSort form-control" name="cls" value="100" />
                </div>
                <span class="red">*</span><span>(大于0的整数)</span>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="name">是否使用</label>
                <div class="col-md-2">
                    <select name="isuse" id="" class="form-control">
                        <option value="1" selected="selected">是</option>
                        <option value="0" >否</option>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-3">
                    <input type="hidden" name='pid' value="{{ $id }}">
                    <input type="submit" class="btn btn-info j_slowsubmit" value=" 提 交 " disabled="disabled" />
                </div>
            </div>


        </form>
    </div>
</div>
@stop

@section('scripts')
<script>

</script>
@endsection