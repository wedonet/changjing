/**
 * Created by Administrator on 2016/11/25.
 */
/******商家后台脚本********/
String.prototype.trim=function() {
    return this.replace(/\s/g,'');
};
function codeError(obj){
    $('.codeErrorBox').css('display','none');
    $(obj).parent().parent().prev().val('').focus();
    $('.fontCount').html('( 请输入<b style="color:red">16</b>个字符 )');

}
//不能为空提示消失
$(document).click(function(e){
    e=e||window.event;
    if(e.target.tagName!=='A' && $('.notFilled').is(':visible')){
        $('.notFilled').css('display','none');
    }
});

function bombBox(obj){
    $(obj).next().find('div:first').animate({width:'300px',height:'150px'},120,function(){
        $(obj).next().find('div:first').animate({width:'280px', height:'140px'},70);
    })
}

