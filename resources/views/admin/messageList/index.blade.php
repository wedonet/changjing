
@extends('admin.layout')


@section('content')

    <ol class="crumb clearfix">
        <li ><a href="/adminconsole" >控制台</a></li>
        <li class="active"> - 信息反馈</li>
        <li class="active"> - 留言列表</li>
    </ol>

    <div class="row page-title-row" style="position:fixed;margin-top:45px;padding-top:20px;background:#fff;z-index: 1000;width:100%;">
        <div class="col-md-3">
            <form action="/adminconsole/MessageList/find" method="POST" >
				{!! csrf_field() !!}
                <select name="u_return" id="" class="form-control" style="display:inline-block;width:75%">
                    <option value="2" @if(!isset($data))selected @endif>全部</option>
                    <option value="0"  @if(isset($data)&&$data['status']=='0') selected @endif>待回访</option>
                    <option value="1" @if(isset($data)&&$data['status']=='1') selected @endif>已回访</option>
                </select>
                <input type="submit" value="查询" class="btn btn-info"/>

            </form>
        </div>
        <div class="col-md-9 text-right">

        </div>

    </div>

    <div class="table-responsive" style="margin-top:140px;">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="10%" >#</th>
                <th width="10%">姓名</th>
                <th width="10%">电话</th>
                <th width="10%">行业</th>
                <th width="10%">留言时间</th>
                <th width="10%">回访人员</th>
                <th width="10%">回访时间</th>
                <th width="10%">状态</th>
                <th width="20%">操作</th>
            </tr>
            </thead>
            <tbody>

            @foreach($message as $v)
                <tr>
                    <td>{{$v->id}}</td>
                    <td>{{$v->u_name}}</td>
                    <td>{{$v->u_phone}}</td>
                    <td>{{$v->u_industry}}</td>
                    <td>{{$v->created_at}}</td>
                    <td>{{$v->u_returningvisitors}}</td>
                    <td>{{$v->revisitdays}}</td>

                    @if($v->u_return == 0)
                        <td>待回访</td>
                    @else
                        <td>已回访</td>
                    @endif

                    <td >
                        <a href="/adminconsole/lookMessageList/{{$v->id}}" class="btn btn-xs btn-warning " title="">
                            <i class="glyphicon glyphicon-eye-open"></i> 查看
                        </a>

                        @if($v->u_return == 0)
                        <div class="adminPopup">
                            <a href="javascript:;" class="btn btn-xs btn-info visit" >
                                <i class="glyphicon glyphicon-book"></i>回访
                            </a>
                            <div class="ifVisit" style="display:none">
                                <form action="/adminconsole/returnvisits/{{$v->id}}" method="post" >
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label class="col-md-1 control-label" for="name" >回访情况</label>
                                        <div class="col-md-10">
                                            <textarea required="required" name="returnvisit" id="" cols="20" rows="5" style="resize: none;" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <p class="divider"></p>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="name"></label>
                                        <input type="submit" class="btn btn-success btn-sm submit" value="提交"/>
                                    </div>
                                </form>
                                <em>&#9670;</em>
                                <span>&#9670;</span>
                            </div>
                        </div>
                        @else
                        @endif

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>




    </div>



    <center>{!! $message->render() !!}
        @if($message->total()==0)<img src="/images/subNull.png" alt=""/>@endif</center>
    @include('admin.partials._modals')
    {{--帮助中心--}}
    <div class="helpContent">
        <a class="foldBtn"><b class="glyphicon glyphicon-arrow-up"></b> <span>收起</span></a>
        <p><i class="glyphicon glyphicon-hand-right"></i> 操作提示 <i class="glyphicon glyphicon-hand-left"></i></p>
        <ol>
            <li>
                <dl>
                    <dt>留言从何而来？</dt>
                    <dd>答：在官网页面中有留言位，客户留言后会进入留言列表中。</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>如何查看最全面的留言信息？</dt>
                    <dd>答：点击留言后的‘查看’按键即可查询最完善的留言信息。</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>回访人员和时间是如何添加的？</dt>
                    <dd>答：点击留言后的‘回访’按键，填写回访情况，点击提交，当时登录的账号和提交时间，将自动记录到回访人员和时间处。</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>已回访和待回访的状态有什么用？</dt>
                    <dd>答：用于区分哪些留言还需进行回访，加快处理进度，减少客户等待时间，更容易达成合作。</dd>
                </dl>
            </li>
        </ol>
    </div>
    {{--帮助中心--}}
@stop
