angular.module('website', ['ng']).config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}])
//头部
    .controller('headerCtrl', ['$scope', function ($scope) {
        var mySwiper3 = new Swiper ('.swiper-container3', {
            virtualTranslate : true,
            onInit: function(mySwiper3){ //Swiper2.x的初始化是onFirstInit
                swiperAnimateCache(mySwiper3,'.anid');
                swiperAnimate(mySwiper3,'.anid');
            }
        });
    }])
//首页
    .controller('homePageCtrl', ['$scope', '$http', function ($scope, $http) {
        (function(){
            var mySwiper = new Swiper ('.swiper-container', {
                effect : 'fade',
                autoplay : 5000,
                loop:true,
                pagination: '.swiper-pagination-h',
                paginationClickable: true,
                autoplayDisableOnInteraction : false,
                spaceBetween: 0,
                lazyLoading : true,
                lazyLoadingInPrevNext : true
            });
        })();
        $(window).scroll(function(event) {
            var objTop;
            $('.scollColor').each(function(e,i){
                objTop = $(i).offset().top- $(window).scrollTop();
                if(objTop<=500&&objTop>=90){
                    $(i).css("color","#4497c5");
                    $(i).next().css("color","#4497c5");
                }else{
                    $(i).css("color","#666");
                    $(i).next().css("color","#c9cacb");
                }
            });


        });
//首页运营方式翻转
        $('.hpOriginTextBox .hpOriginColumn dl').on('mouseover',function(){
            $(this).children('.c1').addClass('face');
            $(this).children('.c2').addClass('con');
        });
        $('.hpOriginTextBox .hpOriginColumn dl').on('mouseleave',function(){
            $(this).children('.c1').removeClass('face');
            $(this).children('.c2').removeClass('con');
        });
//首页案例展示
        var mySwiper1 = new Swiper ('.swiper-container1', {
            onInit: function(mySwiper1){
                swiperAnimateCache(mySwiper1,".anib");
                swiperAnimate(mySwiper1,".anib");
                swiperAnimateCache(mySwiper1,".anic");
                swiperAnimate(mySwiper1,".anic");
            },
            onSlideChangeEnd: function(mySwiper1){
                swiperAnimate(mySwiper1,".anib");
                swiperAnimate(mySwiper1,".anic");
            },
            autoplay:10000,
            pagination: '.swiper-pagination-w',
            prevButton:'.swiper-button-prev',
            nextButton:'.swiper-button-next',
            paginationClickable: true,
            lazyLoading : true,
            lazyLoadingInPrevNext : true

        });
        
        var mySwiper2 = new Swiper ('.swiper-container2', {
            virtualTranslate : true,
            onInit: function(mySwiper2){ //Swiper2.x的初始化是onFirstInit
                swiperAnimateCache(mySwiper2,".ania"); //隐藏动画元素
                swiperAnimate(mySwiper2,".ania"); //初始化完成开始动画
            }
        });

        $(".demo").info();
    }])
//大圣码
    .controller('dashengCodeCtrl', ['$scope', '$http', function ($scope, $http) {
        $(function(){
           // $scope.zoom.init();
            var mySwiper1 = new Swiper ('.swiper-container1', {
                autoplay:10000,
                paginationClickable: true,
                autoplayDisableOnInteraction : false,
                pagination: '.swiper-pagination-w',
                prevButton:'.swiper-button-prev',
                nextButton:'.swiper-button-next',
                onInit: function(mySwiper1){
                    swiperAnimateCache(mySwiper1,".anib");
                    swiperAnimate(mySwiper1,".anib");
                    swiperAnimate(mySwiper1,".anic");
                },
                onSlideChangeEnd: function(mySwiper1){
                    swiperAnimate(mySwiper1,".anib");
                    swiperAnimate(mySwiper1,".anic");
                }
            });
        })

    }])
//溯源防伪
    .controller('originCtrl', ['$scope', '$http', function ($scope, $http) {
        $(function(){
            // $scope.zoom.init();
            var mySwiper1 = new Swiper ('.swiper-container1', {
                scrollbar:'.swiper-scrollbar',
                scrollbarHide : false,
                autoplay:10000,
                paginationClickable: true,
                autoplayDisableOnInteraction : false,
                //pagination: '.swiper-pagination-w',
                prevButton:'.swiper-button-prev',
                nextButton:'.swiper-button-next',
                onInit: function(mySwiper1){
                    swiperAnimateCache(mySwiper1,".anib");
                    swiperAnimate(mySwiper1,".anib");
                    swiperAnimate(mySwiper1,".anic");

                },
                onSlideChangeEnd: function(mySwiper1){
                    swiperAnimate(mySwiper1,".anib");
                    swiperAnimate(mySwiper1,".anic");
                }
            });
        })
       //$scope.origin();

    }])
//典型案例
    .controller('classicCaseCtrl', ['$scope', '$http', function ($scope, $http) {

    }])
//最新动态
    .controller('dynamicCtrl', ['$scope', '$http', function ($scope, $http) {


    }])
//成长历程
    .controller('growthProcesstourismCtrl', ['$scope', function ($scope) {
        $('.growth2 .right li .event').mouseenter(function(){
            $(this).stop().animate({
                left:'-20px'
            },30);
            $(this).prev().css('borderColor','#0091ca');
        });
        $('.growth2 .right li .event').mouseleave(function(){
            $(this).stop().animate({
                left:'0px'
            },30);
            $(this).prev().css('borderColor','transparent');
        });

    }])
//常见问题
    .controller('problemCtrl', ['$scope', '$http', function ($scope, $http) {
        $('.problem2 .problemColumn dl dd.pic').on('click',function(){
            $(this).toggleClass('autoHeight');
        })


    }])
//合作加盟
.controller('cooperateCtrl', ['$scope', '$http', function ($scope, $http) {
        $('.checkboxOne label').on('click',function(e){
            e=e||window.event;
            $(e.target).toggleClass('choose');
            // console.log($('input[type="checkbox"]'))

        });
        if($('input[type="checkbox"]')[0].checked){
            $('input[type="checkbox"]:checked').parent().addClass('choose');
        }


}])
//联系我们
.controller('contactusCtrl', ['$scope', '$http', function ($scope, $http) {

        $('.checkboxOne label').on('click',function(e){
            e=e||window.event;
           $(e.target).toggleClass('choose');
           // console.log($('input[type="checkbox"]'))

        });
        if($('input[type="checkbox"]')[0].checked){
            $('input[type="checkbox"]:checked').parent().addClass('choose');
        }

}])
//父控制器
.controller('parentCtrl', ['$scope', '$http', function ($scope, $http) {

            $('img.lazy').lazyload({  //图片懒加载
                threshold :100
            });

            var mySwiper = new Swiper ('.swiper-container', {
                virtualTranslate : true,
                onInit: function(mySwiper){ //Swiper2.x的初始化是onFirstInit
                    swiperAnimateCache(mySwiper,'.ani');
                    swiperAnimate(mySwiper,'.ani');
                    swiperAnimateCache(mySwiper,'.ania');
                    swiperAnimate(mySwiper,'.ania');
                }
            });


        /*滚动检测*/
        $(document).scroll(function(){
            if(window.pageYOffset > '600'){
                $('#goTop').stop().animate(
                    {'right':'50px'},100
                );
            }else if(window.pageYOffset <= '600'){
                $('#goTop').stop().animate(
                    {'right':'-100px'},100
                );
            }
        });
        /*返回顶部*/
        $('#goTop').click(function(){
            $('html').animate({scrollTop:0}, 200);
            $('body').animate({scrollTop:0}, 200);
        });
        //获取元素外部样式 兼容
        $scope.getStyle = function (element,attr) {
            if(typeof element.currentStyle =='undefined'){
                return window.getComputedStyle(element,null)[attr];
            }else if(element.currentStyle){
                return element.currentStyle[attr];

            }
        }
        //为空提示隐藏
        $(document).click(function(e){
            e=e||window.event;
            if(e.target.tagName!=='A' && $('.notFilled').is(':visible')){
                $('.notFilled').css('display','none');
            }
        });
        //图片左右切换
        $scope.zoom= {
            WIDTH: 0,
            moved: 0,
            MAX: 0,
            MSIZE: 0,
            MAXWIDTH: 0,
            init: function () {

                if (typeof String.prototype.startsWith != 'function') {  //以xx开始的字符串 兼容
                    String.prototype.startsWith = function (prefix){
                        return this.slice(0, prefix.length) === prefix;
                    };
                }
                if (typeof String.prototype.endsWith != 'function') {  //以xx结束的字符串 兼容
                    String.prototype.endsWith = function(suffix) {
                        return this.indexOf(suffix, this.length - suffix.length) !== -1;
                    };
                }


                this.WIDTH= parseFloat($scope.getStyle(document.querySelectorAll(".icon_list>li:first-child")[0],'width'));
                this.MAXWIDTH=$('.icon_list li').length;
                document.querySelectorAll(".preview .icon_list")[0].style.width=this.WIDTH*this.MAXWIDTH+'px';
                document.querySelectorAll(".preview .previewactive")[0].addEventListener("click",this.move.bind(this));
                if(this.MAXWIDTH<=4){
                    document.querySelectorAll("[class^='forward']")[0].className += "_disabled";
                }
            },
            move: function (e) {
                var e = e||window.event;
                var target= e.target;
                if (target.nodeName == "A" && !target.className.endsWith("_disabled")) {
                    this.moved += target.className.startsWith("forward") ? 1 : -1;
                    var left=-(this.WIDTH * this.moved) + "px";
                    $(".icon_list").animate({
                        'left':left
                    },200);
                    this.checkA();
                }
            },
            checkA: function () {
                if (this.moved == 0) {
                    document.querySelectorAll("[class^='backward']")[0].className += "_disabled"; //返回到头
                    document.querySelectorAll("[class^='forward']")[0].className = "forward";
                } else if (this.moved ==  this.MAXWIDTH - 4) {
                    document.querySelectorAll("[class^='forward']")[0].className += "_disabled"; //前进到头
                    document.querySelectorAll("[class^='backward']")[0].className = "backward";
                } else {
                    document.querySelectorAll("[class^='backward']")[0].className = "backward"; //中间
                    document.querySelectorAll("[class^='forward']")[0].className = "forward";
                }
            }




        }
        //防伪溯源页图片切换
        $scope.origin=function() {
            var length,
                currentIndex = 0,
                interval,
                hasStarted = false, //是否已经开始轮播
                t = 5000; //轮播时间间隔


            //将除了第一张图片隐藏
            $('.slider-item:first').addClass('slider-item-selected');
            length = $('.slider-panel').length;
            //隐藏向前、向后翻按钮
            $('.slider-page').hide();
            //鼠标上悬时显示向前、向后翻按钮,停止滑动，鼠标离开时隐藏向前、向后翻按钮，开始滑动
            $('.slider-panel, .slider-pre, .slider-next').hover(function() {
                stop();
                $('.slider-page').show();
            }, function() {
                $('.slider-page').hide();
                start();
            });
            $('.slider-item').hover(function(e) {
                stop();
                var preIndex = $(".slider-item").filter(".slider-item-selected").index();
                currentIndex = $(this).index();
                play(preIndex, currentIndex);
            }, function() {
                start();
            });
            $('.slider-pre').unbind('click');
            $('.slider-pre').bind('click', function() {
                pre();
            });
            $('.slider-next').unbind('click');
            $('.slider-next').bind('click', function() {
                next();
            });
            /**
             * 向前翻页
             */
            function pre() {
                var preIndex = currentIndex;
                currentIndex = (--currentIndex + length) % length;
                play(preIndex, currentIndex);
            }
            /**
             * 向后翻页
             */
            function next() {
                var preIndex = currentIndex;
                currentIndex = ++currentIndex % length;
                play(preIndex, currentIndex);
            }
            /**
             * 从preIndex页翻到currentIndex页
             * preIndex 整数，翻页的起始页
             * currentIndex 整数，翻到的那页
             */
            function play(preIndex, currentIndex) {
                $('.slider-panel').eq(preIndex).stop().fadeOut(500)
                    .parent().children().eq(currentIndex).stop().fadeIn(1000);
                $('.slider-item').removeClass('slider-item-selected');
                $('.slider-item').eq(currentIndex).addClass('slider-item-selected');
            }
            /**
             * 开始轮播
             */
            function start() {
                if(!hasStarted) {
                    hasStarted = true;
                    interval = setInterval(next, t);
                }
            }
            /**
             * 停止轮播
             */
            function stop() {
                clearInterval(interval);
                hasStarted = false;
            }
            //开始轮播
            start();
        };

        (function() {  //首页防伪技术
            $.fn.extend({
                info:function() {
                    var obj=$(this).children("li");

                    var min = obj.last().width();
                    var max = obj.first().width();
                    obj.on('mouseenter', function(){
                        if ($(this).width() == min){

                            $(this).siblings("li").animate({
                                width	:min,
                                opacity	:0.3
                            }, 300).css({
                                cursor:"pointer",
                                boxShadow: "0 0 0 0"
                            });
                            $(this).animate({
                                width	:max,
                                opacity	:1
                            }, 300).css({
                                cursor:"default",
                                boxShadow: "0 0 25px 5px #333"
                            });
                            $(this).siblings("li").children(".out").fadeOut(300);
                            $(this).children(".out").fadeIn(550);
                        };
                    });
                }
            });
        })();

    }])