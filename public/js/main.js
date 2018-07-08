var mytimeout;
var progress;

$(document).ready(function () {

    $('input.j_slowsubmit').removeAttr('disabled');

    $('form.j_form').on('submit', function () {
        j_post($(this));
        return false;
    })

	$('form.longsubmit').on('submit', function(){
		longsubmit($(this));
	});

    $('form.j_formmodal').on('submit', function () {
        j_modalpost($(this));
        return false;
    })

    $('form.j_search').j_search();

		 

    $('a.j_open').on('click', function () {
        j_open($(this));

        return false;
    })

	 $('a.j_confirm').on('click', function () {
		j_confirm($(this));
		return false;
    })

	 $('a.j_confirmpost').on('click', function () {
		j_confirmpost($(this));
		return false;
    })

	 /*隔行变色， hover特效*/
	 $("table.j_list").list();


	$('[data-toggle="tooltip"]').tooltip();

	/*反选*/
	$('#contrasel').on('click', function(){
		contrasel('ids[]');
	});

	/*用链接接交表单，目前用于批量操作*/
	$('a.j_batch').j_batch();


    $('a.j_submitopen').on('click', function () {
        j_submitopen($(this));

        return false;
    })




	//$('#j_content').find('img').addClass('img-responsive');
	/*自动缩放图片*/
	$('#j_content').find('img').each(function(){
		$parent_width = $(this).parent().width();

		$self_width = $(this).width();

		if($self_width > $parent_width){
			$(this).width('100%').height('auto');
		}

		
	
	});


	$('.j_nav').j_nav();

	$('a.loadinglink').on('click', function(){
		$(this).button('loading');
	})

	/*重新加载验证码*/
	$('#captcha a').on('click', function(){
		var obj = $(this);

		var randnum = Math.floor(Math.random() * (31 - 25) + 25) ;
		
		obj.find('img').attr('src', '/captcha?'+ randnum);


	});
	 	

})
//function getHeight(obj){
//    var mainheight = $(obj).contents().find("body").height() + 30;
//    $(obj).height(mainheight);
//}
/*
 * ajax提交表单
 * obj : 表单对象
 * 
 */
function j_post(obj, functionname) { //定义j_p函数（对象和回调名称）
    /*更新编辑器value*/
	 if( typeof(CKEDITOR) != 'undefined'){
    if(CKEDITOR.instances){
        for ( instance in CKEDITOR.instances ){
            CKEDITOR.instances[instance].updateElement();
        }
    }
	 }
    loading();
    /*    UpdateEditorValue(); */
        var data = obj.serialize(); //表单信息

    var url = obj.attr('action');

    /*移除上次的当前表单， 给当前表单加上currentform*/
    /*	 $('form.currentform').removeClass('currentform'); */

    /*	 obj.addClass('currentform');*/

    /*    //把当前提交的表单，保存在data */
    /* $('body').data('currentform', obj.attr('id')); */

    $.ajax({
        cache: false,
        type: 'POST',
        url: url,
        data: data,
        success: function (html) {
				if(html=='notoken'){
					alert('您长时间未进行任何操作，请刷新页面后重新提交');
				}

            /*if有弹出框了先移除*/
            if ($('#modal-info').length > 0 ) {
                $("#modal-info").remove();
                $('.modal-backdrop').remove();
            }
            if ($('#modal-info1').length > 0 ) {
                $("#modal-info1").modal('hide');
                $('.modal-backdrop').remove();
            }

            $('body').append(html);



            $("#modal-info").modal({
                show: true
            })


            //$('#modal-loading').html(html);
            //alert(json);
            removeloading();
            //$('#bg').removeClass('centerloading');
            //functionname(json);
        },
        error: function (xhr, type, error) {
			  if(xhr.status == 419){
				  alert('超时，请重新提交');
			  }else{
				  document.write('Ajax error:' + xhr.responseText);

			  }
			
            //document.write('Ajax error:' + xhr.responseText);

            //alert('Ajax error!');
        }
    })

}


function j_repost(obj, functionname) { //定义j_p函数（对象和回调名称）



    /*    UpdateEditorValue(); */
    var data = obj.serialize(); //表单信息

    var url = obj.attr('action');

    /*移除上次的当前表单， 给当前表单加上currentform*/
    /*	 $('form.currentform').removeClass('currentform'); */

    /*	 obj.addClass('currentform');*/

    /*    //把当前提交的表单，保存在data */
    /* $('body').data('currentform', obj.attr('id')); */

	toastr.options = {  
		closeButton:true


			
	};

    $.ajax({
        cache: false,
        type: 'POST',
        url: url,
        data: data,
		  dataType: "json",
        success: function (json) {

				if('y' == json.suc){
					if( json.hasOwnProperty("info")  ) {
						toastr.success(json.info);
					}
					if( json.hasOwnProperty("url")  ){

                setTimeout(function()
									{									
											window.location.href=json.url;
									}, 2000);					
					}
					if( json.hasOwnProperty("reload")  ){
						
                	window.location.reload(); 
					}
					
			  }else{
					var err = '';
					if(typeof json.err == 'string'){
						err = json.err;
					}else{
						 //for (var item in json.err) {
						//	  console.log(json.err[0][item]);//得到键
							  //console.log(jsondata[0][item]);//得到键对应的值
						//}
							var arrayobj = new Array();

						 for(var o in json.err){  
							 //console.log(json.err[o][0]);
							arrayobj.push( json.err[o][0] );
							//alert(o);  
							//alert(data[o]);  
							//alert("text:"+data[o].name+" value:"+data[o].age );  
						 }  

						 err = arrayobj.join('<br />');
							
						 
					}
					toastr.warning(err);
					//toastr.warning(json.err);
		
			  }
				//toastr.warning('只能选择一行进行编辑');

            //$('body').append(html);
				//alert(html);


            //$("#modal-info").modal({
            //    show: true
            //})

        },
        error: function (xhr, type, error) {
            document.write('Ajax error:' + xhr.responseText);

            //alert('Ajax error!');
        }
    })

}



function j_modalpost(obj, functionname) { //定义j_p函数（对象和回调名称）

    //loading();
    /*    UpdateEditorValue(); */
    var data = obj.serialize(); //表单信息

    var url = obj.attr('action');

	toastr.options = {  
		closeButton:true,	
		positionClass:"toast-top-center"

			
	};

    $.ajax({
        cache: false,
        type: 'POST',
        url: url,
        data: data,
        success: function (html) {
            if('y' == html){
					toastr.success('保存成功，二秒后网页将自动刷新');

					setTimeout("location.reload();",1000)

					
					
				}else{
					toastr.error(html);
				}
        },
        error: function (xhr, type, error) {
            document.write('Ajax error:' + xhr.responseText);

            //alert('Ajax error!');
        }
    })

}


function j_post1(obj, actionUrl) { //定义j_p函数（对象和回调名称）
    //
    ///*更新编辑器value*/
    //if(CKEDITOR.instances){
    //    for ( instance in CKEDITOR.instances ){
    //        CKEDITOR.instances[instance].updateElement();
    //    }
    //}
    loading();

    var data = obj; //表单信息

    var url = actionUrl;

    $.ajax({
        cache: false,
        type: 'POST',
        url: url,
        data: data,
        success: function (html) {

            /*if有弹出框了先移除*/
            if ($('#modal-info').length > 0 ) {
                $("#modal-info").remove();
                $('.modal-backdrop').remove();
            }
            if ($('#modal-info1').length > 0 ) {
                $("#modal-info1").modal('hide');
                $('.modal-backdrop').remove();
            }
            $('body').append(html);
            $("#modal-info").modal({
                show: true
            })
            removeloading();

        },
        error: function (xhr, type, error) {
				alert(erros);
        }
    })

}
function j_open(obj) {

    var url = obj.attr('href');
    /*移除上次的当前表单， 给当前表单加上currentform*/
    /*	 $('form.currentform').removeClass('currentform'); */

    /*	 obj.addClass('currentform');*/

    /*    //把当前提交的表单，保存在data */
    /* $('body').data('currentform', obj.attr('id')); */




    $.ajax({
        cache: false,
        type: 'GET',
        url: url,
        success: function (html) {


            /*if有弹出框了先移除*/
            if ($('#modal-info').length > 0) {
                $('#modal-info').remove();
            }

            $('body').append(html);

				/*弹窗中的ajax提交*/
				$('#modal-info').find('form.j_repost').on('submit', function () {
					
	
					j_repost($(this));

					return false;
				})



           // removeloading();

            $("#modal-info").modal({
                show: true
            })
            //$('.fleft').remove();
            //$('.ac').append('<div class="fleft" > <iframe  src="/adminconsole/upload/class/'+$('#tabup').find('li.active').attr('id')+'" frameborder="0" scrolling="no" width="100%"  height="100%"></iframe></div>')
            //
            //$('#tabup li').on('click',function(){
            //    $('.fleft').remove();
            //    $('.ac').append('<div class="fleft" > <iframe src="/adminconsole/upload/class/'+$(this).attr('id')+'" frameborder="0" scrolling="no" width="100%"  height="100%"></iframe></div>')
            //});


        },
        error: function (xhr, type, error) {
				alert(error);
        }
    })




}


function loading() {
    var str = '';

    str += '<div class="modal" id="modal-loading" >';
    str += '<div class="modal-dialog" style="width:50px;">';
    //str += 		'<div class="modal-content">';

    //str += 			'<div class="modal-body">';
    str += '<img src="/images/loading.gif" alt="" />';
    //str += 			'</div>';

    //str += 		 '</div><!-- /.modal-content -->';
    str += '</div><!-- /.modal-dialog -->';
    str += '</div><!-- /.modal -->';

    if ($('#modal-loading').length < 1) {
        $('body').append(str);
    }


    $("#modal-loading").modal({
        backdrop: 'static',
        show: true
    })

}


function removeloading() {
    $("#modal-loading").modal('hide');
}


//=============================在线编辑器
//模板在线编辑器
//num=1时是管理员编辑器,显示的功能多一些
//num=2时,是普通用户编辑器
//num=3:编辑模板
function wedoneteditor(obj, num, url) {
	num = 2

    if ($("#" + obj).length < 1)
    {
        return false;
    }
    switch (num)
    {
        case 1 :
            CKEDITOR.replace(obj, {
                filebrowserBrowseUrl: '/adminconsole/upload?fromeditor=1',
                filebrowserWindowWidth: '880',
                filebrowserWindowHeight: '585'
            });
            break;
        case 2 :
            //if (ismaster==true)
            //{
            CKEDITOR.replace(obj, {
            });

            //}
            //else{
            //CKEDITOR.replace(obj,{});
            //}
            break;
        case 3 :
            CKEDITOR.replace(obj, {
                enterMode: CKEDITOR.ENTER_BR
            });
            break;
    }
}

function getUrlParam(paramName) {
    var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');

    var match = window.location.search.match(reParam);

    return (match && match.length > 1) ? match[ 1 ] : null;
}


$.fn.AddUrl = function () {
    $(this).bind("click", function () {
        //var funcNum = getUrlParam( 'CKEditorFuncNum' );
        var fileUrl = $(this).attr("href");
        //window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
        window.parent.opener.CKEDITOR.tools.callFunction(3, fileUrl, function () {
            window.parent.close();
        });

        return false;
    })
}

function GetInnerHTML(obj)
{
    var oEditor = FCKeditorAPI.GetInstance(obj);
    return(oEditor.GetXHTML(true));
}

//向在线编辑器插入值
function InsertHTML(str)
{
    var oEditor = FCKeditorAPI.GetInstance("content");
    if (oEditor.EditMode == FCK_EDITMODE_WYSIWYG)
    {
        oEditor.InsertHtml(str);
    }
}
//str 图片obj
//向在线编辑器插入图片
function docoutengimg(obj, str) {
    {
        if (str.lenth == 0) {
            return false;
        }
        if (obj.length == 0) {
            return false;
        }
        //window.parent.CKEDITOR.instances.editor1.insertHtml("a");
        window.parent.CKEDITOR.instances.content.insertHtml("<img src=\"" + $("#" + str).val() + "\" alt=''>");
    }
}


function formatfilelink() {

    var preid = $("#preid", window.parent.document).val();
    var obj = $("#obj", window.parent.document).val();
    var fromeditor = $("#fromeditor", window.parent.document).val();
    var ispre = $("#ispre", window.parent.document).val();
    var CKEditorFuncNum = $("#CKEditorFuncNum", window.parent.document).val();

    if (obj.length > 0)
    {
        $("a.url").bind("click", function () {
            var url = $(this).attr("href");
            var thumb = $(this).attr("rel");
            var src = ''; //

            if ('1' == ispre) {
                src = thumb;
            } else {
                src = url;
            }

            window.parent.document.getElementById(obj).value = src;
            if (preid.length > 0)
            {
                window.parent.document.getElementById(preid).src = src;
            }
            //解决IE iframe后不能聚焦问题
            //$(window.parent.document.getElementById("focus")).focus();


            //window.parent.document.getElementById(obj).focus();

            //$(window.parent.document).find('body').append("<input id='debugfocus' value='' style='position:absolute;top:-9999px;' />");
            //window.parent.document.getElementById('debugfocus').focus();

            //$(window.parent.document.getElementById("bg")).remove();
            //$(window.parent.document.getElementById("edit")).remove();

            $('body',window.parent.document).removeClass('modal-open');
			$(window.parent.document).find(".modal-backdrop").remove();
            $(window.parent.document).find("#modal-info").remove();



            return false;
        })
    } else if (CKEditorFuncNum.length > 0) {

        $("a.url").on("click", function () {
            var url = $(this).attr("href");

            //var dialog = window.parent.CKEDITOR.dialog.getCurrent();
            //dialog.setValueOf('info','txtUrl',url);  // Populates the URL field in the Links dialogue.

            //$(window.parent.document.getElementById("bg")).remove();
            //$(window.parent.document.getElementById("edit")).remove();

            returnFileUrl(url, CKEditorFuncNum);
            return false;
        });
    }
}


// Simulate user action of selecting a file to be returned to CKEditor.
function returnFileUrl(fileUrl, funcNum) {

	//var fileUrl = 'http://c.cksource.com/a/1/img/sample.jpg';

	window.parent.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl, function() {

		 // Get the reference to a dialog window.
		 var dialog = this.getDialog();
		 // Check if this is the Image Properties dialog window.
		 if ( dialog.getName() == 'image' ) {
			  // Get the reference to a text field that stores the "alt" attribute.
			  var element = dialog.getContentElement( 'info', 'txtAlt' );
			  // Assign the new value.
			  if ( element )
					element.setValue( 'alt text' );
		 }
		 // Return "false" to stop further execution. In such case CKEditor will ignore the second argument ("fileUrl")
		 // and the "onSelect" function assigned to the button that called the file manager (if defined).
		 // return false;
	} );
	window.parent.close();
}


function jsAddItemToSelect(objSelect, objItemText, objItemValue) {
	//判断是否存在
	if (jsSelectIsExitItem(objSelect, objItemValue)) {
		alert("该Item的Value值已经存在");
	} else {
	var varItem = new Option(objItemText, objItemValue);
		objSelect.options.add(varItem);
	}
}


$.fn.list = function () {
    var obj = $(this);
    //obj.find("tr").hover(
    //        function () {
    //            $(this).addClass("hover");
    //        },
    //        function () { //如果鼠标移到class为tableborder1的表格的tr上时，执行函数
    //            $(this).removeClass("hover");	 //移除该行的class,给这行添加class值为over，并且当鼠标移出该行时执行函数
    //        });
    //obj.find("tr:even").addClass("alt");
    //列表刷新后,清除所有复选框
    obj.find("input[name=id]").attr("checked", false);

	 /*通过审核变绿*/

	 /*已开始变绿*/
}



/*

*/
function myupload(objid, originnameid, urlid){
	var data = {
		"{{ ini_get('session.upload_progress.name') }}" : "text",
		"inputname" : objid
	}

	$('#'+objid).on('change', function(){
		ajaxFileUpload(objid, originnameid ,  urlid, data);
		myupload(objid, originnameid, urlid, data);
	})
}


/*
input_origin 存原文件名的容器id
input_url 存附件路径的容器id


*/
function ajaxFileUpload(objid, input_origin, input_url, data) {
	//setTimeout('fetch_progress(sessionname)', 1);


	//setTimeout(function()
	//	{					
	//		fetch_progress();				
	//	}, 1);	



	$('#' + objid).hide();
	$('#uploadstatus_' + objid).html('正在上传...');



	$.ajaxFileUpload
	(
		 {
			  url: '/uploadfile', //用于文件上传的服务器端请求地址
			  secureuri: false, //是否需要安全协议，一般设置为false
			  fileElementId: objid, //文件上传域的ID
			  dataType: 'json', //返回值类型 一般设置为json
			  data : data,
			  success: function (data, status)  //服务器成功响应处理函数
			  {	
					if(typeof(data.suc) != 'undefined'){
						if( 'y' == data.suc ){		
							$('#'+ input_url).val(data.fileurl);
							$('#'+ input_origin).val(data.originname);
						}else{
							alert(data.error);
						}
					}

					$('#' + objid).show();
					$('#uploadstatus_'+objid).html('');
			  },
			  error: function (xhr, status, e)//服务器响应失败处理函数
			  {
					$('#' + objid).show();
					$('#uploadstatus'+objid).html('');
					document.write(xhr.responseText);
			  }
		 }
	)


   
}


function fetch_progress(){
	$.get('/getprogress', function(data){

		var progress = parseInt(data);

		$('#uploadstatus').html(progress + '%');

		//$('#progress .label').html(progress + '%');
		//$('#progress .bar').css('width', progress + '%');

		if(progress < 100){
			//progress = setTimeout('fetch_progress(sessionname)', 10);

			setTimeout(function()
				{					
					fetch_progress();				
				}, 10);	
				
		}else{
			$('#uploadstatus').html('over');

			//$('#progress .label').html('完成!');
		}
	});
}


function j_confirm(obj){
	var title = obj.attr('title');
	var action = obj.attr('href');
	var url = '/js/html/confirm.htm';



	//alert(title);
	//$("#modal_text").html($(this).attr('title'));
	//$("#delaction").attr('action', ($(this).attr('href')));
	//$("#modal-delete").modal("show");

	$.ajax({
        cache: false,
        type: 'get',
        url: url,
        success: function (html) {

            /*if有弹出框了先移除*/
            if ($('#modal-info').length > 0) {
                $('#modal-info').remove();
            }

            $('body').append(html);

				$('#confirmaction').attr('action', action);
				$('#confirmtext').text(title);

           // removeloading();
				$('#modal-info').find('form').on('submit', function () {
					j_repost($(this));
					return false;
				});

            $("#modal-info").modal({
                show: true
            })

        },
        error: function (xhr, type, error) {
				alert(error);
        }
    })

}

function j_confirmpost(obj){
	var title = obj.attr('title');
	var action = obj.attr('href');
	var url = '/confirm';

	var data = {
		"title" : title,
		"action" : action
	}

	$.ajax({
        cache: false,
        type: 'get',
        url: url,
		  data : data,
        success: function (html) {

            /*if有弹出框了先移除*/
            if ($('#modal-info').length > 0) {
                $('#modal-info').remove();
            }

            $('body').append(html);

				//$('#confirmaction').attr('action', action);
				//$('#confirmtext').text(title);

        

            $("#modal-info").modal({
                show: true
            })

        },
        error: function (xhr, type, error) {
				alert(error);
        }
    })

}


//全选
function checkall(obj) {
    $("input[name='" + obj + "']").each(function () {
        $(this).attr("checked", true);
    });
}

//全不选
function uncheckall(obj) {
    $("#select").attr("checked", false);
    $("input[name='" + obj + "']").each(function () {
        $(this).attr("checked", false);
    });
}

//反选
function contrasel(obj) {
    $("input[name='" + obj + "']").each(function () {
		  var v = $(this).get(0);


        if ($(this).prop("checked"))
        {
			  v.checked = false;
            //$(this).prop("checked", false);
        } else
        {
			  v.checked = true;
           // $(this).prop("checked", true);
        }
    });
}


function checkradio(obj, value) {

    $("input[name='" + obj + "'][value=" + value + "]").attr("checked", "checked");
}

function removereq(){
	$('input').removeAttr('required');
}




$.fn.j_nav = function () {


	var obj = $(this); 

	obj.find('a').on('click', function(){
		var divid = $(this).attr('rel');

		obj.find('.active').removeClass('active');
		$(this).parent().addClass('active');

		//先把所有容器隐藏掉
		$('.navblock').each(function(){
			if(!$(this).hasClass('hidden')){
				$(this).addClass('hidden');
			}
		});

		//显示这个链接指向的容器
		$('#'+divid).removeClass('hidden');	
	});
}



	
		


	


$.fn.j_search = function () {
	var obj = $(this);

	obj.find('a').on('click', function(){
		var name_ = $(this).attr('rel');
		var value_ = $(this).attr('data');

		obj.find('input[name="'+name_+'"]').val(value_);

		obj.submit();
	})

	/*回写状态*/
	obj.find('input').each(function(){
		var name_ = $(this).attr('name');
		var value_ = $(this).val();

		obj.find('a[rel="'+name_+'"][data="'+value_+'"]').addClass('btn btn-sm btn-success');
	});
}

$.fn.j_batch = function () {
	var obj = $(this);

	obj.on('click', function(){
		var formid = obj.attr('rel');
		var url = obj.attr('href');

		$('#'+formid).attr('action', url).submit();
		return false;
	})


}


/*先收集数据再open
*把收集的数据附加过来
*/
function j_submitopen(obj){	
	var formid = obj.attr('rel');

	var data = $('#' + formid).serialize(); //表单信息	

	var url = obj.attr('href');

	 $.ajax({
        cache: false,
        type: 'GET',
		  data : data,
        url: url,
        success: function (html) {


            /*if有弹出框了先移除*/
            if ($('#modal-info').length > 0) {
                $('#modal-info').remove();
            }

            $('body').append(html);





           // removeloading();

            $("#modal-info").modal({
                show: true
            })
            //$('.fleft').remove();
            //$('.ac').append('<div class="fleft" > <iframe  src="/adminconsole/upload/class/'+$('#tabup').find('li.active').attr('id')+'" frameborder="0" scrolling="no" width="100%"  height="100%"></iframe></div>')
            //
            //$('#tabup li').on('click',function(){
            //    $('.fleft').remove();
            //    $('.ac').append('<div class="fleft" > <iframe src="/adminconsole/upload/class/'+$(this).attr('id')+'" frameborder="0" scrolling="no" width="100%"  height="100%"></iframe></div>')
            //});


        },
        error: function (xhr, type, error) {
				alert(error);
        }
	 })


}


function longsubmit(obj){
	console.log('longsubmit');

	obj.find('input[type=submit]').button('loading');
}