@extends('admin.iframe')
@section('content')
<div id="content-nav">
        <span class="layui-breadcrumb" lay-separator="-">
          <a><cite>活动修业</cite></a>
          <a><cite>学生活动管理</cite></a>
          <a><cite>开课申请</cite></a>
        </span>
</div>
    <div id="iframe-content-wrapper">
        <div class="content">
            <div id="form-wrapper">
                <form class="layui-form" action="/adminconsole/controller/create">
                    <div class="layui-form-item">
                        <label class="layui-form-label">一级活动类型</label>

                        <div class="layui-input-inline">
                            <select name="role_ic">
                                <option value="" selected></option>
                                    <option value=""></option>
                            </select>
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">二级活动类型</label>

                        <div class="layui-input-inline">
                            <select name="role_ic">
                                <option value="" selected></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">牵头部门</label>

                        <div class="layui-input-inline">
                            <select name="role_ic">
                                <option value="" selected></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">课程名称</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">开课学年</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">报名方式</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">活动时长</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">课程开始时间</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">上课地点</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">主办单位类型</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">一级活动类型</label>

                        <div class="layui-input-inline">
                            <select name="role_ic">
                                <option value="" selected></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">单选框</label>
                        <div class="layui-input-block">
                            <input type="radio" name="sex" value="直接报名" title="直接报名">
                            <input type="radio" name="sex" value="需要审核" title="需要审核">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">普通文本域</label>
                        <div class="layui-input-block">
                            <textarea placeholder="请输入内容" rows="20" class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">提交作业开始时间</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">提交作业结束时间</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">课程学分</label>

                        <div class="layui-input-inline">
                            <input type="text" name="u_name" value=""
                                   lay-verify="required|letter_number" placeholder="" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><b class="red"></b></div>
                    </div>
                    <div class="layui-form-item submit-btn">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="form">申请</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
