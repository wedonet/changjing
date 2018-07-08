
var list=1;
$(function(){
    FastClick.attach(document.body);  //300毫秒延迟
    $('.swiper-slide').find('a').each(function(e,i){
            if($(i).hasClass('on')){
               list=$(i).parent().index();
            }
        });
    var mySwiper = new Swiper ('.swiper-container', {
        pagination: '.swiper-pagination-h',
        paginationClickable: true,
        spaceBetween: 50,
        resistanceRatio : 0.7,
        initialSlide :list
        //nextButton: '.swiper-button-next',
        //prevButton: '.swiper-button-prev'
    });
    //$('.swiper-slide').find('a').each(function(e,i){
    //    if($(i).hasClass('on')){
    //        mySwiper.slideTo($(i).parent().index(), 500, false);
    //
    //    }
    //});

})
