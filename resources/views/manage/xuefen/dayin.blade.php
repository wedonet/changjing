<?php

if( array_key_exists('list', $j) ){
	$list =& $j['list'];
}else {
    $list[] = null;
}


if( array_key_exists('currentcontroller', $j) ){
	$currentcontroller =& $j['currentcontroller'];
}else {
    $currentcontroller = '';
}
?>

@extends('manage.layout')


@section('content')

<ol class="crumb clearfix">
    <li><a href="/manage/xuefen">打印学分</a></li>
	<li> - 张三  合计 16 分</li>


	
</ol>

<div class="row page-title-row" >
    <div class="col-md-6">

    </div>
    <div class="col-md-6 text-right" >

        <a href="javascript:;" class="btn btn-info btn-md" type="button">
            打印
        </a>
    </div>

<div class="panel panel-info">


    <div class="panel-body" >

        <div class="panel-body" >

            <table class="table1">
                <tr>
                    <th width="5%">校训大类</th>
                    <th width="10%">目标项目</th>
                    <th width="10%">必修学分</th>
                    <th width="7%">选修学分</th>
                </tr>


                <tr>
                    <td>德</td>
                    <td>思想道德</td>
                    <td><a href="xuefendetail/2">1</a></td>
                    <td>0</td>

                </tr>
                <tr>
                    <td>德</td>
                    <td style="color:red;">责任担当</td>
                    <td>0</td>
                    <td><a href="xuefendetail/2">1</a></td>

                </tr>

                <tr>
                    <td>业</td>
                    <td>学业能力</td>
                    <td><a href="xuefendetail/2">1</a></td>
                    <td>0</td>

                </tr>
                <tr>
                    <td>业</td>
                    <td>职业能力</td>
                    <td><a href="xuefendetail/2">1</a></td>
                    <td>0</td>

                </tr>

                <tr>
                    <td>中</td>
                    <td style="color:red;">传承中国</td>
                    <td>0</td>
                    <td><a href="xuefendetail/2">1</a></td>

                </tr>
                <tr>
                    <td>中</td>
                    <td>中国情怀</td>
                    <td><a href="xuefendetail/2">1</a></td>
                    <td>0</td>

                </tr>

                <tr>
                    <td>外</td>
                    <td style="color:red;">国际视野</td>
                    <td>0</td>
                    <td><a href="xuefendetail/2">1</a></td>

                </tr>
                <tr>
                    <td>外</td>
                    <td style="color:red;">天外气质</td>
                    <td><a href="xuefendetail/2">1</a></td>
                    <td>0</td>

                </tr>

                <tr>
                    <td>求索</td>
                    <td style="color:red;">创新创业</td>
                    <td>0</td>
                    <td><a href="xuefendetail/2">1</a></td>

                </tr>
                <tr>
                    <td>求索</td>
                    <td>科学素养</td>
                    <td><a href="xuefendetail/2">1</a></td>
                    <td>0</td>

                </tr>
                <tr>
                    <td>竞选</td>
                    <td style="color:red;">艺术修养</td>
                    <td>0</td>
                    <td><a href="xuefendetail/2">1</a></td>

                </tr>
                <tr>
                    <td>竞选</td>
                    <td>身心素质</td>
                    <td><a href="xuefendetail/2">1</a></td>
                    <td>0</td>

                </tr>
            </table>
       







    </div>
</div>

@stop

@section('scripts')

@endsection