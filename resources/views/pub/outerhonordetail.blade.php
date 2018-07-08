<?php
/* 校外荣誉详情 */

function showreason($json) {
    echo '';
}
?>
<br />
<table class="table1 table table-striped table-hover">

    <tr>
        <td width="30%">荣誉名称</td>
        <td>{{$data->title}}</td>
    </tr>

    @if(icanseetel($data->ucode) Or isset($showcontact))
    <tr>
		<td>联系人姓名:</td>
		<td>{{$data->conname}}</td>
	</tr>
    <tr>
        <td>联系电话:</td>
        <td>{{$data->contel}}</td>

    </tr>
    @endif

    @if( isset($data->student) )
    <tr>
        <td>审核人</td>
        <td>{{$data->student->dname. '-'. $data->student->classname . '-' .$data->student->realname .'-'. $data->student->mycode }}				</td>
    </tr>
    @endif

    <tr>
        <td>奖励单位</td>
        <td>{{$data->sponsor}}</td>
    </tr>

    <tr>
        <td>奖励日期</td>
        <td>{{formattime2($data->mydate)}}</td>
    </tr>

    <tr>
        <td>奖励金额</td>
        <td>{{$data->myvalue}} 元</td>
    </tr>


    <tr>
        <td>奖励说明</td>
        <td>{{$data->readme}}</td>
    </tr>

    <tr>
        <td>申请学分</td>
        <td>{{$data->mycredit/1000}} 学分</td>
    </tr>


    <tr>
        <td>一级活动类型</td>
        <td>{{$data->type_onename}}</td>
    </tr>
    <tr>
        <td>二级活动类型</td>
        <td>{{$data->type_twoname}}</td>
    </tr>


    <tr>
        <td>牵头部门</td>
        <td>{{$data->tiantouname}}</td>
    </tr>


    <tr>
        <td>辅导员审核状态</td>
        <td>
            <span class="j_pass_{{$data->isok1}}">{{checkstatus($data->isok1)}}</span>
            @if(2 == $data->isok1)
            {{$data->notok1reason}}
            @endif
        </td>
    </tr>


    <tr>
        <td>牵头部门审核状态</td>
        <td>
            <span class="j_pass_{{$data->isok2}}">{{checkstatus($data->isok2)}}</span>
            @if(2 == $data->isok2)
            {{$data->notok2reason}}
            @endif
        </td>
    </tr>


    <tr>
        <td>实得学分</td>
        <td>
            @if($data->isok2 > 0)
            {{$data->actualcredit/1000}} 分
            @endif
        </td>
    </tr>

    <tr>
        <td>申请时间</td>
        <td>{{$data->created_at}}</td>
    </tr>



    <tr>
        <td>支撑材料</td>
        <td>
            @if($data->attachmentsurl=='')
            无
            @else
            <a href="/down?p={!! str_replace('+', '-', base64_encode($data->title.'支撑材料@@@'.$data->attachmentsurl))!!}">下载</a>
            @endif
        </td>
    </tr>
</table>

