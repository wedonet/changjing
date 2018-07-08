<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
     */

    'accepted' => ':attribute错误.',
    'active_url' => ':attribute 不是合法 URL.',
    //'after'                => 'The :attribute must be a date after :date.',
    'after' => ':attribute 必需大于:date.',
    'alpha' => ':attribute 只能出现字母.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num' => ':attribute 只能出现和数字.',
    'array' => ':attribute 必须是数组.',
    'before' => ':attribute 必须早于 :date.',
    'between' => [
        'numeric' => ':attribute 必须在 :min 和 :max 之间.',
        'file' => ':attribute must be between :min 和 :max kilobytes.',
        'string' => ':attribute 必须在 :min 和 :max 字符之间.',
        'array' => ':attribute must have between :min 和 :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => ':attribute 确认错误.',
    'date' => ':attribute 不是合法的日期格式.',
    'date_format' => ':attribute 不是合法的日期格式 :format.',
    'different' => ':attribute 不能与 :other 相同.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'email' => ':attribute 格式错误.',
    'exists' => ':attribute 错误.',
    'filled' => 'The :attribute field is required.',
    'image' => 'The :attribute must be an image.',
    'in' => ':attribute 错误',
    'integer' => ':attribute 不是合法整数.',
    'ip' => 'The :attribute must be a valid IP address.',
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'regex' => ':attribute 格式错误.',
    'required' => '请填写或选择:attribute.',
    'required_if' => '当:other 是 :value :attribute 必填.',
    'required_with' => ':values 存在时, :attribute 必填.',
    'required_with_all' => 'The :attribute field is required when :values is present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => ':attribute 已被占用.',
    'url' => 'The :attribute format is invalid.',
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
//
//    'custom' => [
//        'attribute-name' => [
//            'rule-name' => 'custom-message',
//        ],
//    ],
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'ic' => [
            'required' => 'IC不能为空',
            'alpha_num' => ' IC 必须是数字、字母或其组合,不能使用特殊符号和空格',
            'between' => ' IC必须是2到20位',
            'regex' => ' IC不能输入中文',
        ],
        'upass' => [
            'regex' => '密码必须包含英文字母大小写及数字，且不能有特殊符号',
        ],
        'mytypeid' => [
            'required' => '请选择二维码类型',
        ],
        'cic' => [
            'required' => '栏目IC不能为空',
            'alpha_num' => '栏目 IC 必须是数字、字母或其组合,不能使用特殊符号和空格',
            'between' => '栏目 IC必须是2到20位',
            'regex' => '栏目IC不能输入中文',
        ],
        'r_ic' => [
            'required' => 'IC不能为空',
            'alpha_num' => '识别码 IC 必须是数字、字母或其组合,不能使用特殊符号和空格',
            'between' => '识别码 IC必须是2到20位',
            'regex' => '识别码不能输入中文',
        ],
        'counts' => [
            'required' => '个数不能为空',
            'numeric' => '必须是数字',
            'max' => '不能大于100000',
            'integer' => '必须是整数',
        ],
        'title' => [
            'required' => '名称不能为空',
            'alpha_num' => '名称只能添加数字、字母、中文',
            'between' => '名称必须是:min 到 :max位',
        ],
        'isuse' => [
            'boolean' => '必须是布尔值',
            'numeric' => '必须是数字',
            'required' => '不能为空',
        ],
        'cls' => [
            'required' => '排序不能为空！',
            'numeric' => '排序必须是数字！',
            'integer' => '排序必须是整数',
        ],
        'u_name' => [
            'regex' => '用户名只能为4-20位字母、数字或其组合！',
            'between' => '用户名只能为4-20位！',
        ],
        'name' => [
            'regex' => '用户名只能为字母、数字或其组合！',
        ],
        'u_nick' => [
            'alpha_num' => '昵称只能为字母或数字！',
            'between' => '昵称只能为2-20位！',
        ],
        'u_mobile' => [
            'digits' => '手机号必须为11位！',
            'regex' => '手机号格式不正确！',
        ],
        'u_mail' => [
            'email' => '邮箱只能为@email格式！',
        ],
        'u_pass' => [
            'between' => '密码只能为6-20位！',
            'regex' => '密码只能是数字和字母的组合！',
        ],
        'u_passs' => [
            'between' => '密码只能为6-20位！',
        ],
        //地区里的验证
        'address' => [
            'required' => '地区不能为空',
        ],
        'spell' => [
            'required' => '拼音不能为空',
            'alpha_num' => '必须是拼音',
            'regex' => '请输入正确的拼音',
        ],
        'code' => [
            'required' => '编码不能为空',
            'numeric' => '编码只能是数字',
        ],
        'mytype' => [
            'required' => '类型不能为空',
        ],
        'preimg' => [
            'required' => '请上传预览图',
            'image' => '上传到格式必须是图片',
        ],
        'mycontent' => [
            'size' => '企业介绍文字不要超过1000字',
            'required' => '企业介绍不能为空',
        ],
        'business' => [
            'between' => '所属企业必须是2到20位',
        ],
        'brand' => [
            'between' => '品牌必须是2到20位',
        ],
        'producing_area' => [
            'between' => '产地必须是2到20位',
        ],
        'pack_name' => [
            'required' => '包装名称不能为空',
        ],
        'kg' => [
            'required' => '净重不能为空',
            'numeric' => '净重只能是数字',
        ],
        'keep' => [
            'between' => '储存方法为2到20个字符',
        ],
        'tel' => [
            'numeric' => '联系方式只能是数字',
        ],
        's_name' => [
            'alpha_num' => '分类名称只能添加数字、字母、中文',
        ],
        's_ic' => [
            'regex' => '分类IC格式不正确',
            'between' => '分类IC只能是2到20位'
        ],
        'publishtime' => [
            'required' => '出版时间不能为空',
        ],
        'r_name' => [
            'alpha_num' => '记录名称只能添加数字、字母、中文',
        ],
        'r_ic' => [
            'regex' => '记录IC格式不正确',
            'between' => '记录IC只能是2到20位'
        ],
        'mycontent1' => [
            'required' => '频道内容不能为空',
        ],
        'content' => [
            'required' => '内容不能为空',
        ],
        'name' => [
            'alpha_num' => '名称只能添加数字、字母和中文',
        ],
        'homeworktime_one' => [
            'required_if' => '请填写提交作业开始时间',
        ],
        'homeworktime_two' => [
            'required_if' => '请填写提交作业结止时间',
        ],
        'myplace' => [
            'required' => '请填写地点',
            'between' => '地点必须在255个字符内',
        ],
        'attachmentsurl' => [
            'required' => '请上传附件',
            'between' => '附件路径必须在255个字符内',
        ],
        'captcha' => [
            'captcha' => '验证码错误',
        ],
    ],
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
     */
    'attributes' => [
        'uname' => '登录名',
        'upass' => '密码',
        'contel' => '联系电话',
		'conname' => '联系人姓名',
		'captcha' => '验证码错误',
    ],
];
