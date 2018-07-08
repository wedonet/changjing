<?php

require_once(base_path().'/resources/views/init.blade.php');

$type = $oj->type;
$activity_signup = $oj->activity_signup;
$courses_signup = $oj->courses_signup;
$outerhonor = $oj->outerhonor;
$innerhonor = $oj->innerhonor;
$perform = $oj->perform;

$student = $oj->students;
$allxuefen = $oj->allxuefen;

/*以ic为索引格式化学分*/
foreach($type as $v){
	$t[$v->ic] = $v->target;
	$name[$v->ic] = $v->title;
}

if($oj->isprint){
	$title = '天津外国语大学本科生综合素质教育实践学分成绩单';
	$layout = 'layoutprint';
}else{
	$layout = 'student.layout';
}


/*格式化校外荣誉日期*/
for($i=0; $i<count($outerhonor); $i++){
	$outerhonor[$i]->mydate = formattime1($outerhonor[$i]->mydate);
}

/*格式化校内荣誉日期*/
for($i=0; $i<count($innerhonor); $i++){
	$innerhonor[$i]->mydate = formattime1($innerhonor[$i]->mydate);
}
?>



@extends($layout)


@section('content')

	@if(!$oj->isprint)
    <ol class="crumb clearfix">
        <li><a href="/student/xuefen">我的实践学分</a></li>
    </ol>
	@endif

	@if($oj->isprint)
		<div class="row page-title-row print"  >
		<div class=" text-right" >
			<a href="javascript:doprint();" class="btn btn-success btn-md" type="button">
				打印
			</a>
		</div>
	</div>
	@else
	<div class="row page-title-row" >
		<div class=" text-right" >
			<a href="{{ $currentcontroller }}/xuefen_print" class="btn btn-success btn-md" type="button">
				打印
			</a>
		</div>
	</div>
	@endif


	<div class="logoprint" style="padding:0 0 10px 0"><img src="/images/w/logo_print.png" alt="" /></div>
	<div class="divxuefen">
	<div class="zhang"><img src="/images/w/yin.png" width="150" alt="" /></div>
	<div class="shuiyin" style="width:100%; height:100%;overflow:hidden;position:absolute;top:0;left:0;z-index:-200"><img src="/images/w/shuiyin.png" /></div>

	<h3 class="text-center" style="padding-bottom:18px">天津外国语大学本科生综合素质教育实践学分成绩单</h3>

	
	 <table class="tablexuefenhead">
		<tr>
			<td>学院: {{$student->dname}}</td>
			<td>培养层次: {{$student->culture_level}}</td>
			<td>学制: {{$student->educational_length}} 年</td>
			<td>入学时间: {{$student->entrance_time}}</td>
			<td>学号: {{$student->mycode}}</td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td>专业:{{$student->major}}</td>
			<td>行政班级: {{$student->administrative_class}}</td>
			<td colspan="2">&nbsp;</td>
			<td>姓名: {{$student->realname}}</td>
			<td>累计获得学分: {{$allxuefen/1000}}分</td>
		</tr>
	 </table>




	<?php
		
	?>

	
	<table class="tablexuefen" id='table'>
		<tr>
			<th width="8%">一级校训<br />培养目标</th>
			<th width="12%">二级培养<br />指标</th>
			<th width="8%">目标学分</th>
			<th width="*">名称</th>
			<th width="18%">时间</th>
			<th width="6%">学分</th>
			<th width="6%">等级</th>
			<th width="8%">修业类型</th>
		</tr>
		@foreach($type as $v)	
		@if(0 == $v->mydepth)
		<tr class="type_1_{{$v->ic}}">		
			<td style="vertical-align:middle" class="tdtype1" rowspan="1">{{$v->title}}</td>	
			<td style="vertical-align:middle" class="tdtype2" rowspan="1"></td>
			<td style="vertical-align:middle" class="tdtarget" rowspan="1"></td>
			<td class="tdtitle"></td>
			<td class="tddate"></td>
			<td class="tdcreidt"></td>
			<td class="tdlevel"></td>
			<td class="tdmytype"></td>	
		</tr>
		@endif
		@endforeach
	</table>
	</div>
	



        </div>
    </div>

<script type="text/javascript">
<!--


	
	var type = eval(eval({!! json_encode($type, true) !!}));
	var activity_signup = eval(eval({!! json_encode($activity_signup, true) !!}));
	var courses_signup = eval(eval({!! json_encode($courses_signup, true) !!}));
	var outerhonor = eval(eval({!! json_encode($outerhonor, true) !!}));
	var innerhonor = eval(eval({!! json_encode($innerhonor, true) !!}));
	var perform = eval(eval({!! json_encode($perform, true) !!}));
	var objcredit = new Object(); //按二级分类统计学分


	function formatlevel($x){
		switch($x){
			case  1 :
				return 'A';
				break;
			case  2 :
				return 'B';
				break;
			case  3 :
				return 'C';
				break;
			default:
				return '';
				break;
		}
	}


	function showtype(type){
		var tr;
		var html;
		/*循环二级分类*/
		for(var o in type){
			var href='';

			//if 有二级分类这行了
			if('0' != type[o].pic ){
				href = '/?type2='+type[o].ic;
		
				//上级tr
				tr = $('.type_1_'+type[o].pic);

				/*是否必修*/
				var muststr = '';
				if(1 !=type[o].ismust){
					muststr = '(选修)';
				}

				

				if(tr.hasClass('addedtype2') ){		
					
					/*上级rowspan+1*/
					tr.find('.tdtype1').attr('rowspan', function(index, oldvalue){
						return (oldvalue*1+1);
					});


					
					html = 	'';
					html += '<tr class="type_2_'+type[o].ic+'">';	
					html += '<td style="vertical-align:middle" class="tdtype2" rowspan="1"><a href="'+href+'"> ' + type[o].title + muststr + '</a></td>';
					html += '<td style="vertical-align:middle" class="tdtarget" rowspan="1"><span class="spantarget" data="'+type[o].ic+'">'+type[o].target+'</span></td>';
					html += '<td class="tdtitle"></td>';
					html += '<td class="tddate"></td>';
					html += '<td class="tdcreidt"></td>';
					html += '<td class="tdlevel"></td>';
					html += '<td class="tdmytype"></td>	';
					html += '</tr>';

					tr.after(html);
				}else{	
					//没有时找他父级这一行
					

					tr.find('.tdtype2').html('<a href="'+href+'"> '+type[o].title + muststr+'</a>');
					tr.find('.tdtarget').html('<span class="spantarget" data="'+type[o].ic+'">'+type[o].target+'</span>');

					tr.addClass('addedtype2');					
					tr.addClass('type_2_'+type[o].ic) ;
				}
			} 
		}	
	}

	function showactivity(activity_signup){
		var tr;
		var html;

		/*循环活动*/
		var i=0;
		for(var o in activity_signup){		
			i++;

			if(i>1){
				//break;
			}
			//上级tr
			tr1 = $('.type_1_'+activity_signup[o].type_oneic);
			tr2 = $('.type_2_'+activity_signup[o].type_twoic);


			if(tr2.hasClass('added') ){		
				
				/*上级rowspan+1*/
				tr1.find('.tdtype1').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtype2').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtarget').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});

				html = 	'';
				html += '<tr class="activity_' + activity_signup[o].id + '">';
				html += '	<td class="tdtitle">' + activity_signup[o].title + '</td>';
				html += '	<td class="tddate">' + activity_signup[o].activity_year + '</td>';
				html += '	<td class="tdcreidt">' + activity_signup[o].actualcreidt/1000 + '</td>';
				html += '	<td class="tdlevel">' + formatlevel(activity_signup[o].mylevel) + '</td>';
				html += '	<td class="tdmytype">活动修业</td>	';
				html += '</tr>';

				tr2.after(html);
			}else{	
				//没有时找他父级这一行
				tr2.find('.tdtitle').text(activity_signup[o].title);
				tr2.find('.tddate').text(activity_signup[o].activity_year);
				tr2.find('.tdcreidt').text(activity_signup[o].actualcreidt/1000);
				tr2.find('.tdlevel').text( formatlevel(activity_signup[o].mylevel));
				tr2.find('.tdmytype').text('活动修业');

				tr2.addClass('added');		
				console.log(activity_signup[o].id + activity_signup[o].type_twoic);
			}

			/*加到相应分类的统计*/
			var key = activity_signup[o].type_twoic;
			if( objcredit.hasOwnProperty(key) ){
				objcredit[key] += activity_signup[o].actualcreidt/1000;
			}else{
				objcredit[key] = activity_signup[o].actualcreidt/1000;
			}			
		}	



	}

	/*循环课程*/
	function showcourse(courses_signup){
		var tr;
		var html;

		for(var o in courses_signup){		
			//上级tr
			tr1 = $('.type_1_'+courses_signup[o].type_oneic);
			tr2 = $('.type_2_'+courses_signup[o].type_twoic);

			if(tr2.hasClass('added') ){		
				
				/*上级rowspan+1*/
				tr1.find('.tdtype1').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtype2').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtarget').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});

				html = 	'';
				html += '<tr>';
				html += '<td class="tdtitle">'+courses_signup[o].title+'</td>';
				html += '<td class="tddate">'+courses_signup[o].activity_year+'</td>';
				html += '<td class="tdcreidt">'+(courses_signup[o].actualcreidt/1000)+'</td>';
				html += '<td class="tdlevel">'+(formatlevel(courses_signup[o].mylevel))+'</td>';
				html += '<td class="tdmytype">课程修业</td>	';
				html += '</tr>';

				tr2.after(html);
			}else{	
				//没有时找他父级这一行
				

				tr1.find('.tdtitle').text(courses_signup[o].title);
				tr1.find('.tddate').text(courses_signup[o].activity_year);
				tr1.find('.tdcreidt').text(courses_signup[o].actualcreidt/1000);
				tr1.find('.tdlevel').text( formatlevel(courses_signup[o].mylevel));
				tr1.find('.tdmytype').text('课程修业');
				tr1.find('.tdtarget').text(courses_signup[o].target);

				tr2.addClass('added');			
				//tr2.addClass('course_' + courses_signup[o].id);	
			}

			/*加到相应分类的统计*/
			var key = courses_signup[o].type_twoic;
			if( objcredit.hasOwnProperty(key) ){
				objcredit[key] += courses_signup[o].actualcreidt/1000;
			}else{
				objcredit[key] = courses_signup[o].actualcreidt/1000;
			}
			
		}	
	}


	/*循环荣誉修业*/
	function showouterhonor(obj){
		var tr;
		var html;

		for(var o in obj){		
			//上级tr
			tr1 = $('.type_1_'+obj[o].type_oneic);
			tr2 = $('.type_2_'+obj[o].type_twoic);

			if(tr2.hasClass('added') ){		
				
				/*上级rowspan+1*/
				tr1.find('.tdtype1').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtype2').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtarget').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});

				html = 	'';
				html += '<tr>';
				html += '<td class="tdtitle">'+obj[o].title+'</td>';
				html += '<td class="tddate">'+obj[o].mydate+'</td>';
				html += '<td class="tdcreidt">'+obj[o].actualcredit/1000+'</td>';
				html += '<td class="tdlevel">&nbsp;</td>';
				html += '<td class="tdmytype">荣誉修业</td>	';
				html += '</tr>';

				tr2.after(html);
			}else{	
				//没有时找他父级这一行
				

				tr1.find('.tdtitle').text(obj[o].title);
				tr1.find('.tddate').text(obj[o].mydate);
				tr1.find('.tdcreidt').text(obj[o].actualcredit/1000);
				tr1.find('.tdlevel').text('');
				tr1.find('.tdmytype').text('荣誉修业');
				//tr1.find('.tdtarget').text(obj[o].target);

				tr2.addClass('added');			
				//tr2.addClass('course_' + courses_signup[o].id);	
			}

			/*加到相应分类的统计*/
			var key = obj[o].type_twoic;
			if( objcredit.hasOwnProperty(key) ){
				objcredit[key] += obj[o].actualcreidt/1000;
			}else{
				objcredit[key] = obj[o].actualcreidt/1000;
			}
			
		}	
	}

	/*循环校内荣誉修业*/
	function showinnerhonor(obj){
		var tr;
		var html;

		for(var o in obj){		
			//上级tr
			tr1 = $('.type_1_'+obj[o].type_oneic);
			tr2 = $('.type_2_'+obj[o].type_twoic);

			if(tr2.hasClass('added') ){		
				
				/*上级rowspan+1*/
				tr1.find('.tdtype1').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtype2').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtarget').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});

				html = 	'';
				html += '<tr>';
				html += '<td class="tdtitle">'+obj[o].title+'</td>';
				html += '<td class="tddate">'+obj[o].mydate+'</td>';
				html += '<td class="tdcreidt">'+obj[o].actualcredit/1000+'</td>';
				html += '<td class="tdlevel">&nbsp;</td>';
				html += '<td class="tdmytype">荣誉修业</td>	';
				html += '</tr>';

				tr2.after(html);
			}else{	
				//没有时找他父级这一行
				

				tr1.find('.tdtitle').text(obj[o].title);
				tr1.find('.tddate').text(obj[o].mydate);
				tr1.find('.tdcreidt').text(obj[o].actualcredit/1000);
				tr1.find('.tdlevel').text('');
				tr1.find('.tdmytype').text('荣誉修业');

				//tr1.find('.tdtarget').text(obj[o].target);

				tr2.addClass('added');			
				//tr2.addClass('course_' + courses_signup[o].id);	
			}
			/*加到相应分类的统计*/
			var key = obj[o].type_twoic;
			if( objcredit.hasOwnProperty(key) ){
				objcredit[key] += obj[o].actualcreidt/1000;
			}else{
				objcredit[key] = obj[o].actualcreidt/1000;
			}
			
		}	
	}


	/*循环履职修业*/
	function showperform(obj){
		var tr;
		var html;

		for(var o in obj){		
			//上级tr
			tr1 = $('.type_1_'+obj[o].type_oneic);
			tr2 = $('.type_2_'+obj[o].type_twoic);

			if(tr2.hasClass('added') ){		
				
				/*上级rowspan+1*/
				tr1.find('.tdtype1').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtype2').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});
				tr2.find('.tdtarget').attr('rowspan', function(index, oldvalue){
					return (oldvalue*1+1);
				});

				html = 	'';
				html += '<tr>';
				html += '<td class="tdtitle">'+obj[o].title+'</td>';
				html += '<td class="tddate">'+obj[o].myyear+'</td>';
				html += '<td class="tdcreidt">'+obj[o].actualcredit/1000+'</td>';
				html += '<td class="tdlevel">&nbsp;</td>';
				html += '<td class="tdmytype">履职修业</td>	';
				html += '</tr>';

				tr2.after(html);
			}else{	
				//没有时找他父级这一行
				

				tr1.find('.tdtitle').text(obj[o].title);
				tr1.find('.tddate').text(obj[o].myyear);
				tr1.find('.tdcreidt').text(obj[o].actualcredit/1000);
				tr1.find('.tdlevel').text('&nbsp;');
				tr1.find('.tdmytype').text('履职修业');
				//tr1.find('.tdtarget').text(obj[o].target);

				tr2.addClass('added');			
				//tr2.addClass('course_' + courses_signup[o].id);	
			}
			/*加到相应分类的统计*/
			var key = obj[o].type_twoic;
			if( objcredit.hasOwnProperty(key) ){
				objcredit[key] += obj[o].actualcreidt/1000;
			}else{
				objcredit[key] = obj[o].actualcreidt/1000;
			}
			
		}	
	}


	$(document).ready(function(){
		showtype(type);
		showactivity(activity_signup);	
		showcourse(courses_signup);	

		showouterhonor(outerhonor);	
		showinnerhonor(innerhonor);
		showperform(perform);

		formattarget();//
	})


	function doprint(){
		$('body').find('a').removeAttr('href');

		try{
			print.portrait   =  false    ;//横向打印 
		}catch(e){
			//alert("不支持此方法");
		}
		window.print();    
	}

	/*给目标学分着色，达到了不变，没到打红*/
	function formattarget(){
		$('span.spantarget').each(function(index, html){
			var value = $(this).text();
			var mytype = $(this).attr('data');

			var myactualcredit = 0;

			if(objcredit.hasOwnProperty(mytype)){
				myactualcredit = objcredit[mytype];
			}

			if(value>myactualcredit){

				$(this).addClass('alarm');
			}
			
			
		})
	}

//-->
</script>




@stop


