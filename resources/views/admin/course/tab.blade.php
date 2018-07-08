<div>

    <script>
        $(document).ready(function () {
            $('#{{$tab}}').addClass('active');
        })
    </script>


    <div style="position:relative">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" id="tab_detail"><a href="/adminconsole/course/{{$courseid}}"  aria-controls="home" role="tab" >详情</a></li>
            <li role="presentation" id="tab_shenhe"><a href="/adminconsole/course_shenhe?courseid={{$courseid}}"   aria-controls="profile" role="tab">报名审核</a></li>
            <li role="presentation" id="tab_qiandao"><a href="/adminconsole/course_qiandao?courseid={{$courseid}}"  aria-controls="messages" role="tab">签到</a></li>
            <li role="presentation" id="tab_zuoye"><a href="/adminconsole/course_zuoye?courseid={{$courseid}}"  aria-controls="messages" role="tab">作业</a></li>
            <li role="presentation" id="tab_xuefen"><a href="/adminconsole/course_xuefen?courseid={{$courseid}}"  aria-controls="messages" role="tab">学分认定</a></li>
            <li role="presentation" id="tab_pingjia"><a href="/adminconsole/course_pingjia?courseid={{$courseid}}"  aria-controls="settings" role="tab">评价 {{round($oj->course->appraise/1000, 2)}} <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #cd7f32"></span></a></li>

        </ul>

        <div style="width:500px;position:absolute;top:0;right:0;text-align:right;">@yield('operate')</div>

    </div>


</div>