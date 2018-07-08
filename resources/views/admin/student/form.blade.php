<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">编辑学生信息</div>
    </div>

    <div class="panel-body" >
        <form method="POST" action="{{ $currentcontroller.'/'.$data->id }}" class="form-horizontal j_form bizerRegister"  role="form">
            {!! csrf_field() !!}
			<input type="hidden" name="_method" value="put">


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">姓名</label>
                <div class="col-md-3">
                    <input type="text" placeholder="姓名" required="required" class="form-control" name="realname"  value="{{$data->realname}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">学号</label>
                <div class="col-md-3">
                    <input type="text" placeholder="学号" required="required" class="form-control" name="mycode"  value="{{$data->mycode}}" {{$isedit ? 'readonly="readonly"' : ''}}>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">所属学院</label>
                <div class="col-md-3">
                    <select name="dic" id="j_department" class="form-control">
						<option value="">选择所属学院</option>
						@foreach($j['xueyuanlist'] as $v)
							<option value="{{$v->ic}}">{{$v->title}}</option>
						@endforeach
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">班级</label>
                <div class="col-md-3">
                   <select name="classic" id="j_class" class="form-control">
							
					</select>
                </div>
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" for="title">培养层次</label>
                <div class="col-md-3">
                   <select name="culture_level" id="j_culture_level" class="form-control">
							<option value="本科">本科</option>
							<option value="研究生">研究生</option>
					</select>
                </div>
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" for="title">学制</label>
                <div class="col-md-3">
                   <select name="educational_length" id="j_educational_length" class="form-control">
							<option value="1">1年</option>
							<option value="2">2年</option>
							<option value="3">3年</option>
							<option value="4">4年</option>
							<option value="5">5年</option>
							<option value="6">6年</option>
							<option value="7">7年</option>
					</select> 
                </div>
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" for="title">入学时间</label>
                <div class="col-md-3">
					<div class="input-group ">
                  		<input type="text" value="{{$data->entrance_time}}"  class="form-control datepicker" name="entrance_time" 
						required="required">
						<span class="input-group-addon"><span class="glyphicon glyphicon-date"></span></span>
					</div>
                </div>
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" for="title">专业</label>
                <div class="col-md-3">
                  <input type="text" placeholder="专业" required="required" class="form-control" name="major"  value="{{$data->major}}">
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label">性别</label>
                <div class="col-md-3">
				    <select name="gender" id="j_gender" class="form-control">
							<option value="男">男</option>
							<option value="女">女</option>
					</select>
                    
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">手机号</label>
                <div class="col-md-3">
                    <input type="text" placeholder="手机号" class="form-control" name="mobile"  value="{{$data->mobile}}">
                </div>
            </div>

			<div class="form-group">
                <label class="col-md-4 control-label" for="title">身份证号</label>
                <div class="col-md-3">
                    <input type="text" required="required" class="form-control" name="mynumber"  value="{{$data->mynumber}}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="title">邮箱</label>
                <div class="col-md-3">
                    <input type="text" placeholder="邮箱" required="required" class="form-control" name="email"  value="{{$data->email}}">
                </div>
            </div>
           
            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-info j_slowsubmit" value=" 提 交 " disabled="disabled" />
                </div>
            </div>

        </form>
		
		<br /><br />

        <form method="POST" action="{{ $currentcontroller.'_savepass' }}" class="form-horizontal j_form bizerRegister"  role="form">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{$data->id}}">


            <div class="form-group">
                <label class="col-md-4 control-label" for="title">新密码</label>
                <div class="col-md-3">
                    <input type="text" placeholder="请输入密码" required="required" class="form-control" name="upass"  value="">
                </div>
                
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="readme">确认密码</label>
                <div class="col-md-3">
                    <input type="text" placeholder="请再输一次" required="required" class="form-control" name="upass2" value="">
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


<script>
<!--

var classlist = '{{!!json_encode($j["classlist"],true)!!}}';
var b = eval(eval(classlist));

$(document).ready(function(){
	/*日期时间选择*/
	$('.datepicker').datetimepicker({
		language:  'zh-CN',
		autoclose: true,
		minView: 2, 
		format: 'yyyy-mm-dd'
			

	});


	$('#j_department').val('{{$data->dic}}');
	$('#j_gender').val('{{$data->gender}}');

	var dic='{{$data->dic}}';


	var optionlist = '';
	
	for(var o in b){
		if( b[o].dic == dic ){
			optionlist += ('<option value="'+b[o].mycode+'">'+b[o].title+'</option>');
		}
	}

	$('#j_department').on('change', function(){
		var dic = $(this).val();
		var optionlist = '<option value="">选择班级</option>';
		
		for(var o in b){
			if( b[o].dic == dic ){
				optionlist += ('<option value="'+b[o].mycode+'">'+b[o].title+'</option>');
			}
		}

		$('#j_class').empty().append(optionlist);

		//var classlist = '<option>英语一班</option>';
		//	classlist += '<option>英语二班</option>';
		//if($(this).val() == '1'){
		//	$('#j_class').empty().append(classlist);
		//}
	})


	$('#j_class').empty().append(optionlist);

	$('#j_class').val('{{$data->classic}}');

	$('#j_culture_level').val('{{$data->culture_level}}');

	$('#j_educational_length').val('{{$data->educational_length}}');

})
//-->
</script>