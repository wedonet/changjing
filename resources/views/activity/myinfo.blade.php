<table class="tableinfo1" style="margin:10px 0 20px 0;">
			<tr>
				<th width="8%">活动类型</th>
				<td width="30%">{{$data->type_onename}} / {{$data->type_twoname}}</td>
				<th width="8%">活动级别</th>
				<td width="20%">{{activitylevel($data->mylevel)}}</td>
				<th width="8%">活动时长</th>
				<td width="*">{{$data->mytimelong}} 学时</td>
			</tr>

			<tr>
				<th>活动时间</th>
				<td>{{formattime2($data->plantime_one)}}</td>
				<th>活动地点</th>
				<td>{{$data->myplace}}</td>
				<th>活动学分</th>
				<td>{{$data->mycredit/1000}} 学分</td>
			</tr>

			<tr>
				<th>报名时间</th>
				<td>{{formattime2($data->signuptime_one) . ' 至 ' . formattime2($data->signuptime_two)}}</td>

				<th>人数限制</th>
				<td>{{formatlimit($data->signlimit)}}</td>

				<th>附件</th>
				<td>
				@if($data->attachmentsurl=='')
				无
				@else
				<a href="/downattach?p={!! str_replace('+', '-', base64_encode($data->originname.'@@@'.$data->attachmentsurl))!!}">{{$data->originname}}</a>
				@endif
	
				
				</td>

	
			</tr>
		</table>
	

	
		
