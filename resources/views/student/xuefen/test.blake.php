<div class="t1">
		<div class="tr  clearfix">
			<div class="td">一级校训<br />培养目标</div>
			<div class="td">二级培养<br />指标</div>
			<div class="td">目标学分</div>
			<div class="td">名称</div>
			<div class="td">学分</div>
			<div class="td"> 修业类型</div>
		</div>

		@foreach($type as $v)
		@if(0 == $v->mydepth)
			<div class="tr  clearfix">
				<div class="td" style="width:200px">{{$v->title}}</div>
				<div class="td clearfix" style="width:200px">
					@foreach($type as $w)
					@if($w->pic == $v->ic)
						<div class="td" style="width:100px">{{$w->title}}</div>
						<div class="td" style="width:90px">10</div>
						
						<div class="td clearfix" style="width:200px">
							@foreach($activity as $x)
							@if($x->type_twoic == $w->ic)
								<div class="td" style="width:100px">{{$w->title}}</div>
								<div class="td" style="width:90px">10</div>
								<div class="td" style="width:90px">活动修业</div>
							@endif
							@endforeach
						</div>
					@endif
					@endforeach
				</div>			
			</div>
		@endif
		@endforeach
	</div>