<?php
/* 校外荣誉详情 */

function showreason($json) {
    echo '';
}
?>
<br />
<table class="table1 table table-striped table-hover">

    <tr>
        <td width="30%">姓名</td>
        <td width="30%">{{$data->realname}}</td>
        <td width="*">&nbsp;</td>
    </tr>



    <tr>
        <td>学号</td>
        <td>{{$data->ucode}}</td>
        <td></td>
    </tr>

    @if(icanseetel($data->sucode))
    <tr>
		<td>联系人姓名:</td>
		<td>{{$data->conname}}</td>
		<td></td>
	</tr>
    <tr>
        <td>联系电话:</td>
        <td>{{$data->contel}}</td>
        <td></td>
    </tr>
    @endif
    <tr>
        <td>聘职学年</td>
        <td>{{$data->myyear}}</td>
        <td></td>
    </tr>

    <tr>
        <td>职务全称</td>
        <td>{{$data->title}}</td>
        <td></td>
    </tr>

    <tr>
        <td>聘任部门</td>
        <td>{{$data->mydname}}</td>
        <td></td>
    </tr>

    <tr>
        <td>类型</td>
        <td>{{$data->type_onename}}/{{$data->type_twoname}}</td>
        <td></td>
    </tr>

    <tr>
        <td>申请学分</td>
        <td>{{$data->mycredit/1000}} 学分</td>
        <td></td>
    </tr>


    <tr>
        <td>牵头部门</td>
        <td>{{$data->tiantouname}}</td>
        <td></td>
    </tr>


    <tr>
        <td>状态</td>
        <td>
            <span class="j_pass_{{$data->isok}}">{{checkstatus($data->isok)}}</span>
            @if(1==$data->isok And '' != $data->okway)
            ({{$data->okway}})
            @endif

            @if(2 == $data->isok)
            {{$data->notokreason}}
            @endif
        </td>
        <td></td>
    </tr>


    <tr>
        <td>申请时间</td>
        <td>{{$data->created_at}}</td>
        <td></td>
    </tr>

</table>

