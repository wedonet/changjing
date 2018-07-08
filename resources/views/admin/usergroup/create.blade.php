@extends('admin.layout')


@section('content')
<ol class="crumb clearfix">
    <li><a href="/adminconsole">控制台</a></li>
    <li class="active"> - 用户管理</li>
    <li><a href="/adminconsole/usergroup"> - 用户组</a></li>
    <li class="active"> - 新建用户组</li>
</ol>


<!-- Display Validation Errors -->
<div class="row page-title-row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-right">
        <a href="/adminconsole/usergroup" class="btn btn-success btn-md addNewNav" type="button">
            返回上一层
        </a>
    </div>

</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">新建用户组</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{ url('adminconsole/usergroup') }}" class="form-horizontal j_form bizerRegister"  role="form">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-md-4 control-label" for="name">用户组名称</label>
                <div class="col-md-3">
                    <input type="text" placeholder="名称" required="required" class="form-control" name="title" value="">
                </div>
                <span class="red">*</span><span>(类型限制:数字、字母和中文，长度不限)</span>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="name">识别码( IC )</label>
                <div class="col-md-3">
                    <input type="text" placeholder="唯一标识" required="required" class="form-control" name="ic">
                </div>
                <span class="red">*</span><span>(2-20位数字、字母或其组合) 注：新建之后不可修改</span>
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
                    <input type="submit" class="btn btn-info j_slowsubmit" value=" 提 交 " disabled="disabled" />
                </div>
            </div>


        </form>
    </div>
</div>
{{--帮助中心--}}
<div class="helpContent">
    <a class="foldBtn"><b class="glyphicon glyphicon-arrow-up"></b> <span>收起</span></a>
    <p><i class="glyphicon glyphicon-hand-right"></i> 操作提示 <i class="glyphicon glyphicon-hand-left"></i></p>
    <ol>
        <li>
            <dl>
                <dt>什么是识别码（IC）？</dt>
                <dd>答：识别码（IC）是用户组的唯一识别码，不可重复，不能进行更改。</dd>
            </dl>
        </li>

    </ol>
</div>
{{--帮助中心--}}
@stop

@section('scripts')
<script>

</script>
@endsection