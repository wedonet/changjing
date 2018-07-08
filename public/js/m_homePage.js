$(function(){
    FastClick.attach(document.body);  //300毫秒延迟

})

angular.module('website', ['ng']).config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

}])
//顶部
    .controller('headerCtrl', ['$scope', function ($scope) {
        $('.topList').on('click',function(){
            $scope.domCilck();
        });
        $('.list-navBox a').on('click',function(){
            $scope.domCilck();
        });
        $('.list-navBox').on('click',function(e){
            var ot=$(this);
            if($(e.target).is(ot)){
                $scope.domCilck();
            }
        });
      $scope.domCilck=function(){
            $('.list-navBox').toggle();
            $('.top .topList .img').toggleClass('changeImg');
        }

    }])
//首页
    .controller('homePageCtrl', ['$scope', '$http', function ($scope, $http) {
        $scope.onCompletion();
        var Swiper1= new Swiper('.swiper-container', {
            effect : 'fade',
            autoplay:5000,
            pagination : '.swiper-pagination',
            autoplayDisableOnInteraction : false,
            scrollbarHide:false,
            loop:true,
            lazyLoading : true,
            lazyLoadingInPrevNext : true
        });
        var Swiper2=new Swiper('.swiper-container1',{
            slidesPerView : 2,
            slidesPerGroup : 1,
            spaceBetween : 20


        })


    }])
    //关于1溯源
    .controller('aboutOriginCtrl', ['$scope',function ($scope) {

    }])
    //服务项目
    .controller('aerviceItemsCtrl', ['$scope',function ($scope) {

    }])
    //典型案例
    .controller('classicCaseCtrl', ['$scope',function ($scope) {

    }])
    //最新动态
    .controller('newsCtrl', ['$scope',function ($scope) {
        //$('.newsClassification a').on('click',function(){
        //    if(!$(this).parent().hasClass('active')){
        //        $(this).parent().addClass('active');
        //        $(this).parent().siblings().removeClass('active');
        //        var index=$(this).parent().index();
        //        var obj=$('.news section')[index];
        //        $(obj).fadeIn(100);
        //        $(obj).siblings().fadeOut(100);
        //    }
        //})

    }])
    //新闻详情
    .controller('newDetailsCtrl', ['$scope',function ($scope) {

    }])
    //常见问题
    .controller('questionCtrl', ['$scope','$rootScope',function ($scope,$rootScope) {
        $('.questionList li').on('click',function(){
            $(this).find('.answer').toggle();
            $(this).find('b').toggleClass('up');
            $scope.onCompletion();
        });
    }])
//父控制器
    .controller('parentCtrl', ['$scope', '$http', '$rootScope',function ($scope, $http,$rootScope) {
        //window.onload=function(){
        //
        //
        //
        //}
        $scope.onCompletion =function() {
            setTimeout(function(){
                myScroll.refresh();
            },100);

        };
    }])
