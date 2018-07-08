<?php

/*课程详情*/


?>
<br />
<table class="table1 table table-striped table-hover">

	<tr>
		<td width="30%">名称：</td>
		<td width="*">{{$data->title}}</td>
		<td  width="20%"></td>
	</tr>

	@if(array_key_exists('department',$j))
	<tr>
		<td>发起部门：</td>
		<td>{{$j['department']->title}}</td>
		<td></td>
	</tr>
	@endif



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
		<td>开通状态</td>
		<td class="j_open_{{($data->isopen)}}">{{openstatus($data->isopen)}}</td>
		<td class="gray">开通的课程可以报名参加</td>
	</tr>

	<tr>
		<td>学年</td>
		<td>{{$data->activity_year}} 学年</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>一级类型</td>
		<td>{{$data->type_onename}}</td>
		<td class="gray"></td>
	</tr>
	<tr>
		<td>二级类型</td>
		<td>{{$data->type_twoname}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>级别</td>
		<td>{{ ('school'==$data->mylevel)? '校级' : '院级'}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>时长</td>
		<td>{{$data->mytimelong}}学时</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>学分</td>
		<td>{{$data->mycredit/1000}} 学分</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>开始时间</td>
		<td>{{formattime2($data->plantime_one)}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>结束时间</td>
		<td>{{formattime2($data->plantime_two)}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>报名开始时间</td>
		<td>{{formattime2($data->signuptime_one)}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>报名结束时间</td>
		<td>{{formattime2($data->signuptime_two)}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>主办单位</td>
		<td>{{$data->sponsor}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>地点</td>
		<td>{{$data->myplace}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>是否需要提交作业</td>
		<td>{{ (1==$data->homework)? '是':'否'}}</td>
		<td class="gray"></td>
	</tr>

	@if(1==$data->homework)
	<tr>
		<td>提交作业开始时间</td>
		<td>{{formattime2($data->homeworktime_one)}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>提交作业结止时间</td>
		<td>{{formattime2($data->homeworktime_two)}}</td>
		<td class="gray"></td>
	</tr>
	@endif


	<tr>
		<td>报名方式</td>
		<td>{{signupmethod($data->mywayic)}}</td>
		<td class="gray"></td>
	</tr>

	
	<tr>
		<td>报名人数限制</td>
		<td>{{personlimit($data->signlimit)}}</td>
		<td class="gray"></td>
	</tr>


	<tr>
		<td>预览图</td>
		<td><img src="{{$data->preimg}}" alt="" class="img-responsive center-block" /></td>

	</tr>

	<tr>
		<td>介绍</td>
		<td>{{$data->readme}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>备注</td>
		<td>{{$data->other}}</td>
		<td class="gray"></td>
	</tr>

	<tr>
		<td>附件</td>
		<td>


		@if($data->attachmentsurl=='')
		无
		@else
		<a href="/downattach?p={!! str_replace('+', '-', base64_encode($data->originname.'@@@'.$data->attachmentsurl))!!}">{{$data->originname}}</a>
		@endif
		</td>
		<td class="gray"></td>
	</tr>

	@if(isset($oj->hour))
	<tr>
		<td>课时</td>
		<td colspan="2">
			@foreach($oj->hour as $v)
			    <div style="padding-bottom:5px;">第{{$loop->index+1}}课 :
					 {{formattime2($v->start_time) . ' 至 ' . formattime2($v->finish_time)}}
				{{$v->myplace}}
				</div>
			@endforeach
		</td>

	</tr>
	@endif
</table>

<div style="margin-top:15px" id="j_content">
{!!$data->content!!}
</div>