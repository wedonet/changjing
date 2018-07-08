/**********************/
/*大圣码后台*/
/**********************/

$(function() {
    
    //帮助中心收起打开
    $('.foldBtn').on('click',function(){
        $('.helpContent ol').slideToggle(300,function(){
            if($(this).is(':hidden')){
                $('.foldBtn span').html('展开');
                $('.foldBtn b').attr('class','glyphicon glyphicon-arrow-down');
            }else{
                $('.foldBtn span').html('收起');
                $('.foldBtn b').attr('class','glyphicon glyphicon-arrow-up');
            }


        });

    });
    //$('.foldBtn').on('click',function(){
    //    $('.helpContent ol').toggleClass('telescopic');
    //    if($('.helpContent ol').hasClass('telescopic')){
    //        $('.foldBtn span').html('展开');
    //        $('.foldBtn b').attr('class','glyphicon glyphicon-arrow-down');
    //    }else{
    //        $('.foldBtn span').html('收起');
    //        $('.foldBtn b').attr('class','glyphicon glyphicon-arrow-up');
    //    }
    //});

//    if (window.history && window.history.pushState) {  //后退时刷新
//        $(window).on('popstate', function () {
//            var hashLocation = location.hash;
//            var hashSplit = hashLocation.split("#!/");
//            var hashName = hashSplit[1];
//            if (hashName !== '') {
//                var hash = window.location.hash;
//                if (hash === '') {
//                    history.go(0);
//                }
//            }
//        });
//        window.history.pushState('forward', null, '');
//    }
//页面淡入
    fade();
//自动隐藏消息提示
    var timer = setTimeout(function () {
        $('.messagePrompt').fadeOut(1000);
        timer = null;
    }, 3000);

//删除
    $('a.j_del').on('click', function () {
        $("#modal-delete").modal("show");
        var title1=this.getAttribute('data-title1');
        var title2=this.getAttribute('data-title2');
        var title3=this.getAttribute('data-title3');
        $("#modal_title1").html(title1);
        $("#modal_title2").html(title2);
        $("#modal_title3").html(title3);
        $("#delaction").attr('action', ($(this).attr('href')));
        return false;
    });

//删除提示
    $('.j_del').tooltip();
        //getTime();
        /*滚动检测*/
        $(document).scroll(function(){
            if(window.pageYOffset > '300'){
                $('#goTop').stop().animate(
                    {'right':'15px'},100
                );
            }else if(window.pageYOffset <= '300'){
                $('#goTop').stop().animate(
                    {'right':'-25px'},100
                );
            }
        });
/*返回顶部*/
        $('#goTop').click(function(){
            $('body,html').animate({scrollTop:0}, 200);
            return false;
        });

        /*侧边栏样式*/
        //$('#sideContorl').find('li.hover').parent().parent().parent().addClass('active');
        //$('#sideContorl').find('li.active>a').children('i.glyphicon:last').remove();
        //$('#sideContorl').find('li.active>a').append('<i class="glyphicon glyphicon-chevron-up"></i>');

        //if($('#sideContorl').find('li.hover').parent().parent().parent().hasClass('active')){}
/*模糊搜索*/
    $('.vagueSearch').focus(function(){
        if($(this).next().html()!==''){
            $(this).next().css('opacity','1');
        }
    });
    $('.vagueSearch').blur(function(){
        $(this).next().css('opacity','0');
    });

/*数字排序验证*/
    $('.numSort').keyup(function(){
        $(this).val($(this).val().replace(/[^\d]/g,''));
        if($(this).val()<1){
            $(this).val('');
        }
    });

/*收起侧边栏*/
    $('.clickHide').on('click', function () {
        var a = $('.sidebar');
        if (a.hasClass('open')) {
            a.animate({
                left: '-16.67%'
            }, 200, function () {
                a.removeClass('open')
                a.addClass('closed')
                $('.clickHide').css('background-position', '-21px -61px')
            });
            $('.main').animate({
                marginLeft: '0',
                width: '100%'
            }, 200);
            $('.businessNav').animate({
                width: '95%'
            }, 200)
        } else {
            a.animate({
                left: '0px'
            }, 200, function () {
                a.removeClass('closed')
                a.addClass('open')
                $('.clickHide').css('background-position', '0 0')
            });
            $('.main').animate({
                marginLeft: '16.67%',
                width: '83.33%'
            }, 200);
            $('.businessNav').animate({
                width: '79%'
            }, 200)
        }
    });
    /*调用侧边栏点击方法*/
    //$.sideFold('#sideContorl>li>a', '#sideContorl>li>div', 'fast', 'click');
    $('#sideContorl li.hover').parent().parent().css('display', 'block');
//管理弹出
    $('.adminChoose').on('click', function () {
            $('table').find('div.showyes').css('display', 'none');
            $(this).next().fadeIn();
            if ($(this).parent().parent().prev().prev().html() == 'yes') {
                $(this).next().find('.sd').css('display', 'block');
                $(this).next().find('.sd label:first input').attr('checked', 'checked');
                $(this).next().find('.sh label:first input').removeAttr('checked');
                $(this).next().find('.sh').remove();
            } else {
                $(this).next().find('.sh').css('display', 'block');
                $(this).next().find('.sd').remove();
                $(this).next().find('.sh label:first input').attr('checked', 'checked');
                $(this).next().find('.sd label:first input').removeAttr('checked');

            }
        });
//回访弹出
    $('.visit').on('click', function () {
        $('table').find('div.ifVisit').css('display', 'none');
        $(this).next().fadeIn();
        if ($(this).parent().parent().prev().prev().html() == '待回访') {
            $(this).next().find('.sd').css('display', 'block');
            $(this).next().find('.sd label:first input').attr('checked', 'checked');
            $(this).next().find('.sh label:first input').removeAttr('checked');
            $(this).next().find('.sh').remove();
        }
    });
    $(document).click(function (e) {
        var e = e.srcElement || e;

        if (!($(e.target).hasClass('showyes')) && !($(e.target).hasClass('adminChoose'))) {
            $('.showyes').fadeOut();
        }
        if (!($(e.target).hasClass('ifVisit')) && !($(e.target).hasClass('visit'))) {
            $('.ifVisit').fadeOut();
        }

        $('.showyes').click(function (e) {
            var e = e.srcElement || e;
            e.stopPropagation();
        });
        $('.ifVisit').click(function (e) {
            var e = e.srcElement || e;
            e.stopPropagation();
        });
    });

    //管理提示消息点击提交自动刷新
    $('.showyes .submit').on('click', function () {

        $('.showyes').fadeOut(function () {
            location.replace(location.href);
        });
    });


})







/**********************/
/*函数*/
/**********************/
//String.prototype.trim=function() { //去空格
//    return this.replace(/\s/g,'');
//};
function chooseSearch(obj){ //模糊搜索
    $(obj).parent().prev().val($(obj).html());
   // $(obj).parent().prev().attr('value',$(obj).html());
    //$(obj).parent().empty();
    //$(obj).parent().css('visibility','hidden');

}
function searchFn(obj,url,bids){
    var me=obj;
    if($(obj).val()!==''){

        $.post(url,{key:$(me).val(),bid:bids},function(data){
            $(me).next().css('display','block');
            $(me).next().css('opacity','1');
            if(data!=='no'){
                $(me).next().empty();
                for(var i=0;i<data.length;i++){
                    $(me).next().append('<li  onclick="chooseSearch(this)">'+data[i]+'</li>');
                }
            }else{
                $(me).next().empty();
                $(me).next().append('<li>暂无查询数据..</li>');
            }
        });
    }else{
        $(me).next().empty();
        $(me).next().css('opacity','0');
    }
}
////侧边栏手风琴
//jQuery.sideFold = function(obj,obj_c,speed,Event){
//    $(obj).on(Event,function(){
//
//        if(!$(this).parent().hasClass('.active')){
//            $(this).parent().siblings('.active').find('a.btn').children('i.glyphicon:last-child').remove();
//            $(this).parent().siblings('.active').find('a.btn').append('<i class="glyphicon glyphicon-chevron-down"></i>');
//            $(this).parent().siblings('.active').removeClass('active')
//            $(this).children('i.glyphicon:last-child').remove();
//            $(this).append('<i class="glyphicon glyphicon-chevron-up"></i>');
//            $(this).parent().addClass('active');
//        }
//        if($(this).next().is(":visible")){
//            $(obj_c).slideUp(speed);
//            $(this).children('i.glyphicon:last-child').remove();
//            $(this).append('<i class="glyphicon glyphicon-chevron-down"></i>');
//        }else{
//            $(obj_c).slideUp(speed);
//            $(obj).removeClass("selected");
//            $(this).next().slideDown(speed).end().addClass("selected");
//
//
//        }
//    });
//}


//获取ID
function getId(obj){
    var id=
        $(obj).parent().parent().find('td:first').html();

    var href=$(obj).attr('href')+'/'+id;
    $(obj).attr('href',href);

}

//新建角色获取ID
function getRoleId(obj){
    var id=window.location.pathname.slice(window.location.pathname.lastIndexOf('/')+1);
    var href=$(obj).attr('href')+'/'+id;
    $(obj).attr('href',href);

}
//产品页新建/编辑自动切换下一个tab
function switchTab(){
    if($('.editNav').find('li.active').index()<4){
        var obj=$('.editNav').find('li.active');
        $('.editNav').find('li.active').removeClass('active');
        obj.next().addClass('active');
        $('.tab-content').find('div.active').removeClass('active').next().addClass('active');
    }


}
/*table,panel-body淡入*/
function fade(){
    $('table').css('display','none');
    $('table').fadeIn(250);
}
//时间计时
function getTime(){
    //alert(year+'年'+month+'月'+day+'日 '+hour':'+minute+':'+second)
    setInterval(function(){
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth()+1;
        var day = date.getDate();
        var hour = date.getHours();
        var minute = date.getMinutes();
        var second = date.getSeconds();
        if(minute<'10'){
            minute='0'+minute;
        }
        if(second<'10'){
            second='0'+second;
        }
        $('.getTime').html(year+'年'+month+'月'+day+'日 '+hour+'时'+minute+'分'+second+'秒');
    },1000);
}
//城市搜索
function citySearch(obj){
    $('.searchText').focus(function(){
        $('.cityPrompt').css('display','none');
    });
    obj.on('click',function(){
        if($('.searchText').val()!==''){
            var val=$(this).prev().val().trim().replace(/省|市|县|区/,"");
            $('table tbody').find('tr.red').removeClass('red');
            $('table tbody tr').each(function(e,i){
                var cityPattern = new RegExp(val);
                if( val!=='' && cityPattern.test($(i).find('td:nth-child(2)').html())){
                    $(i).addClass('red');
                    var sum=i.offsetTop;
                    while((i=i.offsetParent)!=null){
                        sum+=i.offsetTop;
                    }
                    $('html').animate({scrollTop:sum-200}, 200);
                    $('body').animate({scrollTop:sum-200}, 200);

                    $('.cityPrompt').css('display','none');
                    return false;
                }
            });
                if(!$('table tbody tr').hasClass('red')){
                    $('.cityPrompt').css('display','inline');
                    $('.cityPrompt b').html('暂无查询地区！');
                    $('.cityPrompt b').stop().animate({opacity:'1.0'},100).animate({opacity:'0.0'},100).animate({opacity:'1.0'},100).animate({opacity:'0.0'},100).animate({opacity:'1.0'},100);

                }
                if(val==''){
                    $('.cityPrompt').css('display','inline');
                    $('.cityPrompt b').html('请输入所要查询的地区！');

                }


        }
    });
}
//调用城市
function cityChoose(){
    (function (factory) {
        if (typeof define === 'function' && define.amd) {
            define(['jquery', 'ChineseDistricts'], factory);
        } else if (typeof exports === 'object') {
            factory(require('jquery'), require('ChineseDistricts'));
        } else {
            factory(jQuery, ChineseDistricts);
        }
    })(function ($, ChineseDistricts) {

        if (typeof ChineseDistricts === 'undefined') {
            throw new Error('The file "city-picker.data.js" must be included first!');
        }

        var NAMESPACE = 'citypicker';
        var EVENT_CHANGE = 'change.' + NAMESPACE;
        var PROVINCE = 'province';
        var CITY = 'city';
        var DISTRICT = 'district';

        function CityPicker(element, options) {
            this.$element = $(element);
            this.$dropdown = null;
            this.options = $.extend({}, CityPicker.DEFAULTS, $.isPlainObject(options) && options);
            this.active = false;
            this.dems = [];
            this.needBlur = false;
            this.init();
        }

        CityPicker.prototype = {
            constructor: CityPicker,

            init: function () {

                this.defineDems();

                this.render();

                this.bind();

                this.active = true;
            },

            render: function () {
                var p = this.getPosition(),
                    placeholder = this.$element.attr('placeholder') || this.options.placeholder,
                    textspan = '<span class="city-picker-span" style="' +
                        this.getWidthStyle(p.width) + 'height:' +
                        p.height + 'px;line-height:' + (p.height - 1) + 'px;">' +
                        (placeholder ? '<span class="placeholder">' + placeholder + '</span>' : '') +
                        '<span class="title"></span><div class="arrow"></div>' + '</span>',

                    dropdown = '<div class="city-picker-dropdown" style="left:0px;top:100%;' +
                        this.getWidthStyle(p.width, true) + '">' +
                        '<div class="city-select-wrap">' +
                        '<div class="city-select-tab">' +
                        '<a class="active" data-count="province">省份</a>' +
                        (this.includeDem('city') ? '<a data-count="city">城市</a>' : '') +
                        (this.includeDem('district') ? '<a data-count="district">区县</a>' : '') + '</div>' +
                        '<div class="city-select-content">' +
                        '<div class="city-select province" data-count="province"></div>' +
                        (this.includeDem('city') ? '<div class="city-select city" data-count="city"></div>' : '') +
                        (this.includeDem('district') ? '<div class="city-select district" data-count="district"></div>' : '') +
                        '</div></div>';

                this.$element.addClass('city-picker-input');
                this.$textspan = $(textspan).insertAfter(this.$element);
                this.$dropdown = $(dropdown).insertAfter(this.$textspan);
                var $select = this.$dropdown.find('.city-select');

                // setup this.$province, this.$city and/or this.$district object
                $.each(this.dems, $.proxy(function (i, type) {
                    this['$' + type] = $select.filter('.' + type + '');
                }, this));

                this.refresh();
            },

            refresh: function (force) {
                // clean the data-item for each $select
                var $select = this.$dropdown.find('.city-select');
                $select.data('item', null);
                // parse value from value of the target $element
                var val = this.$element.val() || '';
                val = val.split('/');
                $.each(this.dems, $.proxy(function (i, type) {
                    if (val[i] && i < val.length) {
                        this.options[type] = val[i];
                    } else if (force) {
                        this.options[type] = '';
                    }
                    this.output(type);
                }, this));
                this.tab(PROVINCE);
                this.feedText();
                this.feedVal();
            },

            defineDems: function () {
                var stop = false;
                $.each([PROVINCE, CITY, DISTRICT], $.proxy(function (i, type) {
                    if (!stop) {
                        this.dems.push(type);
                    }
                    if (type === this.options.level) {
                        stop = true;
                    }
                }, this));
            },

            includeDem: function (type) {
                return $.inArray(type, this.dems) !== -1;
            },

            getPosition: function () {
                var p, h, w, s, pw;
                p = this.$element.position();
                s = this.getSize(this.$element);
                h = s.height;
                w = s.width;
                if (this.options.responsive) {
                    pw = this.$element.offsetParent().width();
                    if (pw) {
                        w = w / pw;
                        if (w > 0.99) {
                            w = 1;
                        }
                        w = w * 100 + '%';
                    }
                }

                return {
                    top: p.top || 0,
                    left: p.left || 0,
                    height: h,
                    width: w
                };
            },

            getSize: function ($dom) {
                var $wrap, $clone, sizes;
                if (!$dom.is(':visible')) {
                    $wrap = $("<div />").appendTo($("body"));
                    $wrap.css({
                        "position": "absolute !important",
                        "visibility": "hidden !important",
                        "display": "block !important"
                    });

                    $clone = $dom.clone().appendTo($wrap);

                    sizes = {
                        width: $clone.outerWidth(),
                        height: $clone.outerHeight()
                    };

                    $wrap.remove();
                } else {
                    sizes = {
                        width: $dom.outerWidth(),
                        height: $dom.outerHeight()
                    };
                }

                return sizes;
            },

            getWidthStyle: function (w, dropdown) {
                if (this.options.responsive && !$.isNumeric(w)) {
                    return 'width:' + w + ';';
                } else {
                    return 'width:' + (dropdown ? Math.max(320, w) : w) + 'px;';
                }
            },

            bind: function () {
                var $this = this;

                $(document).on('click', (this._mouteclick = function (e) {
                    var $target = $(e.target);
                    var $dropdown, $span, $input;

                    if ($target.is('.city-picker-span')) {
                        $span = $target;
                    } else if ($target.is('.city-picker-span *')) {
                        $span = $target.parents('.city-picker-span');
                    }
                    if ($target.is('.city-picker-input')) {
                        $input = $target;
                    }
                    if ($target.is('.city-picker-dropdown')) {
                        $dropdown = $target;
                    } else if ($target.is('.city-picker-dropdown *')) {
                        $dropdown = $target.parents('.city-picker-dropdown');
                    }
                    if ((!$input && !$span && !$dropdown) ||
                        ($span && $span.get(0) !== $this.$textspan.get(0)) ||
                        ($input && $input.get(0) !== $this.$element.get(0)) ||
                        ($dropdown && $dropdown.get(0) !== $this.$dropdown.get(0))) {
                        $this.close(true);
                    }

                }));

                this.$element.on('change', (this._changeElement = $.proxy(function () {
                    this.close(true);
                    this.refresh(true);
                }, this))).on('focus', (this._focusElement = $.proxy(function () {
                    this.needBlur = true;
                    this.open();
                }, this))).on('blur', (this._blurElement = $.proxy(function () {
                    if (this.needBlur) {
                        this.needBlur = false;
                        this.close(true);
                    }
                }, this)));

                this.$textspan.on('click', function (e) {
                    var $target = $(e.target), type;
                    $this.needBlur = false;
                    if ($target.is('.select-item')) {
                        type = $target.data('count');
                        $this.open(type);
                    } else {
                        if ($this.$dropdown.is(':visible')) {
                            $this.close();
                        } else {
                            $this.open();
                        }
                    }
                }).on('mousedown', function () {
                    $this.needBlur = false;
                });

                this.$dropdown.on('click', '.city-select a', function () {
                    var $select = $(this).parents('.city-select');
                    var $active = $select.find('a.active');
                    var last = $select.next().length === 0;
                    $active.removeClass('active');
                    $(this).addClass('active');
                    if ($active.data('code') !== $(this).data('code')) {
                        $select.data('item', {
                            address: $(this).attr('title'), code: $(this).data('code')
                        });
                        $(this).trigger(EVENT_CHANGE);
                        $this.feedText();
                        $this.feedVal(true);
                        if (last) {
                            $this.close();
                        }
                    }
                }).on('click', '.city-select-tab a', function () {
                    if (!$(this).hasClass('active')) {
                        var type = $(this).data('count');
                        $this.tab(type);
                    }
                }).on('mousedown', function () {
                    $this.needBlur = false;
                });

                if (this.$province) {
                    this.$province.on(EVENT_CHANGE, (this._changeProvince = $.proxy(function () {
                        this.output(CITY);
                        this.output(DISTRICT);
                        this.tab(CITY);
                    }, this)));
                }

                if (this.$city) {
                    this.$city.on(EVENT_CHANGE, (this._changeCity = $.proxy(function () {
                        this.output(DISTRICT);
                        this.tab(DISTRICT);
                    }, this)));
                }
            },

            open: function (type) {
                type = type || PROVINCE;
                this.$dropdown.show();
                this.$textspan.addClass('open').addClass('focus');
                this.tab(type);
            },

            close: function (blur) {
                this.$dropdown.hide();
                this.$textspan.removeClass('open');
                if (blur) {
                    this.$textspan.removeClass('focus');
                }
            },

            unbind: function () {

                $(document).off('click', this._mouteclick);

                this.$element.off('change', this._changeElement);
                this.$element.off('focus', this._focusElement);
                this.$element.off('blur', this._blurElement);

                this.$textspan.off('click');
                this.$textspan.off('mousedown');

                this.$dropdown.off('click');
                this.$dropdown.off('mousedown');

                if (this.$province) {
                    this.$province.off(EVENT_CHANGE, this._changeProvince);
                }

                if (this.$city) {
                    this.$city.off(EVENT_CHANGE, this._changeCity);
                }
            },

            getText: function () {
                var text = '';
                this.$dropdown.find('.city-select')
                    .each(function () {
                        var item = $(this).data('item'),
                            type = $(this).data('count');
                        if (item) {
                            text += ($(this).hasClass('province') ? '' : '/') + '<span class="select-item" data-count="' +
                            type + '" data-code="' + item.code + '">' + item.address + '</span>';
                        }
                    });
                return text;
            },

            getPlaceHolder: function () {
                return this.$element.attr('placeholder') || this.options.placeholder;
            },

            feedText: function () {
                var text = this.getText();
                if (text) {
                    this.$textspan.find('>.placeholder').hide();
                    this.$textspan.find('>.title').html(this.getText()).show();
                } else {
                    this.$textspan.find('>.placeholder').text(this.getPlaceHolder()).show();
                    this.$textspan.find('>.title').html('').hide();
                }
            },

            getCode: function (count) {
                var obj = {}, arr = [];
                this.$textspan.find('.select-item')
                    .each(function () {
                        var code = $(this).data('code');
                        var count = $(this).data('count');
                        obj[count] = code;
                        arr.push(code);
                    });
                return count ? obj[count] : arr.join('/');
            },

            getVal: function () {
                var text = '';
                this.$dropdown.find('.city-select')
                    .each(function () {
                        var item = $(this).data('item');
                        if (item) {
                            text += ($(this).hasClass('province') ? '' : '/') + item.address;
                        }
                    });
                return text;
            },

            feedVal: function (trigger) {
                this.$element.val(this.getVal());
                if(trigger) {
                    this.$element.trigger('cp:updated');
                }
            },

            output: function (type) {
                var options = this.options;
                //var placeholders = this.placeholders;
                var $select = this['$' + type];
                var data = type === PROVINCE ? {} : [];
                var item;
                var districts;
                var code;
                var matched = null;
                var value;

                if (!$select || !$select.length) {
                    return;
                }

                item = $select.data('item');

                value = (item ? item.address : null) || options[type];

                code = (
                    type === PROVINCE ? 86 :
                        type === CITY ? this.$province && this.$province.find('.active').data('code') :
                            type === DISTRICT ? this.$city && this.$city.find('.active').data('code') : code
                );

                districts = $.isNumeric(code) ? ChineseDistricts[code] : null;

                if ($.isPlainObject(districts)) {
                    $.each(districts, function (code, address) {
                        var provs;
                        if (type === PROVINCE) {
                            provs = [];
                            for (var i = 0; i < address.length; i++) {
                                if (address[i].address === value) {
                                    matched = {
                                        code: address[i].code,
                                        address: address[i].address
                                    };
                                }
                                provs.push({
                                    code: address[i].code,
                                    address: address[i].address,
                                    selected: address[i].address === value
                                });
                            }
                            data[code] = provs;
                        } else {
                            if (address === value) {
                                matched = {
                                    code: code,
                                    address: address
                                };
                            }
                            data.push({
                                code: code,
                                address: address,
                                selected: address === value
                            });
                        }
                    });
                }

                $select.html(type === PROVINCE ? this.getProvinceList(data) :
                    this.getList(data, type));
                $select.data('item', matched);
            },

            getProvinceList: function (data) {
                var list = [],
                    $this = this,
                    simple = this.options.simple;

                $.each(data, function (i, n) {
                    list.push('<dl class="clearfix">');
                    list.push('<dt>' + i + '</dt><dd>');
                    $.each(n, function (j, m) {
                        list.push(
                            '<a' +
                            ' title="' + (m.address || '') + '"' +
                            ' data-code="' + (m.code || '') + '"' +
                            ' class="' +
                            (m.selected ? ' active' : '') +
                            '">' +
                            ( simple ? $this.simplize(m.address, PROVINCE) : m.address) +
                            '</a>');
                    });
                    list.push('</dd></dl>');
                });

                return list.join('');
            },

            getList: function (data, type) {
                var list = [],
                    $this = this,
                    simple = this.options.simple;
                list.push('<dl class="clearfix"><dd>');

                $.each(data, function (i, n) {
                    list.push(
                        '<a' +
                        ' title="' + (n.address || '') + '"' +
                        ' data-code="' + (n.code || '') + '"' +
                        ' class="' +
                        (n.selected ? ' active' : '') +
                        '">' +
                        ( simple ? $this.simplize(n.address, type) : n.address) +
                        '</a>');
                });
                list.push('</dd></dl>');

                return list.join('');
            },

            simplize: function (address, type) {
                address = address || '';
                if (type === PROVINCE) {
                    return address.replace(/[省,市,自治区,壮族,回族,维吾尔]/g, '');
                } else if (type === CITY) {
                    return address.replace(/[市,地区,回族,蒙古,苗族,白族,傣族,景颇族,藏族,彝族,壮族,傈僳族,布依族,侗族]/g, '')
                        .replace('哈萨克', '').replace('自治州', '').replace(/自治县/, '');
                } else if (type === DISTRICT) {
                    return address.length > 2 ? address.replace(/[市,区,县,旗]/g, '') : address;
                }
            },

            tab: function (type) {
                var $selects = this.$dropdown.find('.city-select');
                var $tabs = this.$dropdown.find('.city-select-tab > a');
                var $select = this['$' + type];
                var $tab = this.$dropdown.find('.city-select-tab > a[data-count="' + type + '"]');
                if ($select) {
                    $selects.hide();
                    $select.show();
                    $tabs.removeClass('active');
                    $tab.addClass('active');
                }
            },

            reset: function () {
                this.$element.val(null).trigger('change');
            },

            destroy: function () {
                this.unbind();
                this.$element.removeData(NAMESPACE).removeClass('city-picker-input');
                this.$textspan.remove();
                this.$dropdown.remove();
            }
        };

        CityPicker.DEFAULTS = {
            simple: false,
            responsive: false,
            placeholder: '请选择省/市/区',
            level: 'district',
            province: '',
            city: '',
            district: ''
        };

        CityPicker.setDefaults = function (options) {
            $.extend(CityPicker.DEFAULTS, options);
        };

        // Save the other citypicker
        CityPicker.other = $.fn.citypicker;

        // Register as jQuery plugin
        $.fn.citypicker = function (option) {
            var args = [].slice.call(arguments, 1);

            return this.each(function () {
                var $this = $(this);
                var data = $this.data(NAMESPACE);
                var options;
                var fn;

                if (!data) {
                    if (/destroy/.test(option)) {
                        return;
                    }

                    options = $.extend({}, $this.data(), $.isPlainObject(option) && option);
                    $this.data(NAMESPACE, (data = new CityPicker(this, options)));
                }

                if (typeof option === 'string' && $.isFunction(fn = data[option])) {
                    fn.apply(data, args);
                }
            });
        };

        $.fn.citypicker.Constructor = CityPicker;
        $.fn.citypicker.setDefaults = CityPicker.setDefaults;

        // No conflict
        $.fn.citypicker.noConflict = function () {
            $.fn.citypicker = CityPicker.other;
            return this;
        };

        $(function () {
            $('[data-toggle="city-picker"]').citypicker();
        });
    });

}
