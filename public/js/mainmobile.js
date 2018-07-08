/**********************/
/*大圣码后台*/
/**********************/

$(function() {   
	var timer = setTimeout(function () {
	  $('.messagePrompt').fadeOut(1000);
	  timer = null;
	}, 3000);



	/*返回顶部*/
	$('#goTop').click(function(){
		$('body,html').animate({scrollTop:0}, 200);
		return false;
	});


})







/**********************/
/*函数*/
/**********************/

