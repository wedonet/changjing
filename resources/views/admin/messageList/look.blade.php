
@extends('admin.layout')


@section('content')

    <ol class="crumb clearfix">
        <li ><a href="/adminconsole" >控制台</a></li>
        <li class="active"> - 信息反馈</li>
        <li ><a href="/adminconsole/MessageList"> - 留言列表</a></li>
        <li class="active"> - 查看</li>
    </ol>

    <div class="row page-title-row">
        <div class="col-md-3">
            
        </div>
        <div class="col-md-9 text-right">
            <a href="/adminconsole/MessageList" class="btn btn-success btn-md">返回上一级</a>
        </div>
 
    </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">查看留言信息</div>
        </div>
        <div  style="width:70%;margin:50px auto;">
            <table class=" table  table-hover table-bordered">

                <tbody >

                    <tr>
                        <th width="15%" class="warning">姓名</th>
                        <td>{{ $message->u_name }}</td>
                    </tr>
                    <tr>
                        <th class="warning">电话</th>
                        <td>{{ $message->u_phone }}</td>
                    </tr>
                    <tr>
                        <th class="warning">行业</th>
                        <td>{{ $message->u_industry }}</td>
                    </tr>
                    <tr>
                        <th class="warning">留言</th>
                        <td>{{ $message->u_message }}</td>
                    </tr>
                    <tr>
                        <th class="warning">想要了解</th>
                        <td>{{ $message->u_understand }}</td>
                    </tr>
                    <tr>
                        <th class="warning">留言时间</th>
                        <td>{{ $message->created_at }}</td>
                    </tr>
                    <tr>
                        <th class="warning">回访人员</th>
                        <td>{{ $message->u_returningvisitors }}</td>
                    </tr>
                    <tr>
                        <th class="warning">回访时间</th>
                        <td>{{ $message->revisitdays }}</td>
                    </tr>
                    <tr>
                        <th class="warning">回访情况</th>
                        <td>{{ $message->u_returnvisit }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>




    @include('admin.partials._modals')
@stop
