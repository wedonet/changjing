<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use \Illuminate\Support\MessageBag as MessageBag;

class studentController extends Controller {

    private $j;
    private $parent;
    private $viewfolder;
    private $dbname;

    function __construct() {
        $this->currentcontroller = '/adminconsole/student'; //控制器
        $this->viewfolder = 'admin.student'; //视图路径
        $this->dbname = 'students';

        $this->j['nav'] = 'student';
        $this->j['currentcontroller'] = $this->currentcontroller;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $rules = array(
            'realname' => 'nullable|string|between:1,20',
            'mycode' => 'nullable|string|between:1,20'
        );

        $attributes = array(
            "realname" => '姓名',
            'mycode' => '学号'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors(($validator->errors()->toArray()));
        }

        $search['realname'] = $request->realname;
        $search['mycode'] = $request->mycode;

        $this->j['search'] = $search;



        $list = DB::table($this->dbname)
                ->where('isdel', 0)
                ->where(function($query) use($search) {
                    if ('' != $search['realname']) {
                        $query->where('realname', 'like', '%' . $search['realname'] . '%');
                    }
                    if ('' != $search['mycode']) {
                        $query->where('mycode', 'like', '%' . $search['mycode'] . '%');
                    }
                })
                ->orderby('id', 'desc')
                ->paginate(20);

        $this->j['list'] = $list;

        return view($this->viewfolder . '.index', ['j' => $this->j]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $xueyuanlist = app('main')->getxueyuanlist();
        $classlist = app('main')->getclasslist();

        $this->j['xueyuanlist'] = $xueyuanlist;
        $this->j['classlist'] = $classlist;

        return view($this->viewfolder . '.create', ['j' => $this->j]);
    }

    private function getbase(&$request) {
        $base = (object) [];
        $base->rules = array(
            'realname' => 'required|string|between:1,20',
            'dic' => 'required|string|between:1,20', //所属学院
            'classic' => 'required|string|between:1,20', //
            'culture_level' => 'required|string|between:1,20', //培养层次
            'gender' => 'required|string|in:"男","女"',
            /**/
            'educational_length' => 'required|integer', //学制
            'entrance_time' => 'required|date',
            'major' => 'required|string|between:1,20',
            'mobile' => 'nullable|regex:/^1[34578]\d{9}$/',
            'email' => 'required|email|between:1,50',
            'mynumber' => 'required|string|between:18,18',
        );
        $base->message = array(
            'mynumber.between' => '身份证格式错误',
        );
        $base->attributes = array(
            'realname' => '姓名',
            'dic' => '所属学院',
            'classic' => '所属班级',
            'culture_level' => '培养层次',
            'gender' => '性别',
            /**/
            'educational_length' => '学制',
            'entrance_time' => '入学时间',
            'major' => '专业',
            'mobile' => '手机号',
            'email' => '邮箱',
            'mynumber' => '身份证号',
        );

        return $base;
    }

    function basemdb(&$request) {
        $mdb = (object) [];
        $mdb->m = new MessageBag;


        /* 获取部门（学院）名称 */
        $dic = $request->dic;
        $department = app('main')->getdepartmentdatabyic($dic);
        if (!$department) {
            $mdb->m->add('null', '没找到所在部门，请重新选择');
            return $mdb;
        }
        $dname = $department->title;

        /* 获取班级名称 */
        $classic = $request->classic;
        $class = app('main')->getclassdatabyic($classic);
        if (!$department) {

            $mdb->m->add('null', '没找到所在班级，请重新选择');
            return $mdb;
        }
        $classname = $class->title;

        /**/
        $date = date("Y-m-d H:i:s", time());



        $rs['realname'] = $request->realname;
        $rs['dic'] = $request->dic;
        $rs['dname'] = $dname;

        $rs['classic'] = $request->classic;
        $rs['classname'] = $classname;
        $rs['administrative_class'] = $classname;

        $rs['culture_level'] = $request->culture_level;
        /**/
        $rs['educational_length'] = $request->educational_length;
        $rs['entrance_time'] = $request->entrance_time;
        $rs['major'] = $request->major;


        $rs['gender'] = $request->gender;
        $rs['mobile'] = $request->mobile . '';
        $rs['email'] = $request->email;

        $rs['mynumber'] = $request->mynumber;


        $mdb->date = $date;
        $mdb->rs = $rs;

        return $mdb;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $base = $this->getbase($request);

        $myrules = array(
            'mycode' => 'required|unique:students,mycode|string|between:1,20',
            'upass' => 'required|confirmed|string|between:1,255'
        );
        $myattributes = array(
            'mycode' => '学号',
            'upass' => '密码'
        );

        $rules = array_merge($base->rules, $myrules);
        $attributes = array_merge($base->attributes, $myattributes);
        $message = $base->message;


        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /* 检测确认密码 */
//        if ($request->upass !== $request->upass2) {
//            $validator->errors()->add('error2', '验证密码错误！');
//            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
//        }
        $mdb = $this->basemdb($request);

        $m = $mdb->m;


        if (!$mdb->m->isEmpty()) {
            return ( app('main')->ajaxvali($mdb->m->toArray()) );
        }
        $rs = $mdb->rs;



        $rs['mycode'] = $request->mycode;
        $rs['upass'] = bcrypt($request->upass);

        $rs['isdel'] = 0;
        $rs['created_at'] = $mdb->date;


        if (DB::table($this->dbname)->insert($rs)) {
            $suctip[] = '<a href="' . $this->currentcontroller . '">返回学生管理</a>';
            return ( app('main')->jssuccess('保存成功', $suctip));
        } else {
            $validator->errors()->add('error', '保存失败');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        return redirect($this->currentcontroller);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

//        return view($this->viewfolder . '.daoru', ['j' => $this->j]);
        ini_set('max_execution_time', '0');
//        $file = $request->file('photo');
//        if($file->isValid()){
//            $originalName = $file->getClientOriginalName(); // 文件原名
//            $ext = $file->getClientOriginalExtension();     // 扩展名
//            $realPath = $file->getRealPath();   //临时文件的绝对路径
//            $type = $file->getClientMimeType();     // image/jpeg
//            $ym = date('Ym');
//            $upimagerootdir = 'excel/student';
//            $upimagedir = $upimagerootdir . '/' . $ym;
//            $destPath = realpath(public_path($upimagerootdir)) . DIRECTORY_SEPARATOR . $ym;
//            if (!file_exists($destPath)) {
//                mkdir($destPath, 0755, true);
//            }
//            $filename = date('dHis') . '-' . uniqid(str_random(4)) . '.' . $ext;
//            $result = $file->move($destPath, $filename);
//            $filePath=$destPath.'\\'.$filename;
        $filePath = 'excel\student\201712\05183234-73uR5a2675c2b3a9d.xlsx';

        Excel::load($filePath, function($reader) {
            $reader = $reader->getSheet(0);
            $results = $reader->toArray();

//            dd($results);
            if (empty($results)) {
                return redirect()->back()->withInput()->withErrors('导入文件格式错误,导入失败');
            }



            $num = count($results[0]);
            if ($num != 35) {
                return redirect()->back()->withInput()->withErrors('导入文件格式错误,导入失败');
            }


            $n = count($results);

            /* 导入院系 */
            $yuanxi = DB::table('students')->groupby('dname')->pluck('dname')->toarray();
            ;
            $yn = count($yuanxi);
            for ($i = 0; $i < $yn; $i++) {
                $yuanxisql['ic'] = app('main')->getfirstic();
                $yuanxisql['title'] = $yuanxi[$i];
                $yuanxisql['isxueyuan'] = 1;
                $yuanxisql['cls'] = 100;
                $yuanxisql['isdel'] = 0;
                $yuanxisql['mytype'] = 'yewu';
                $aa = DB::table('departments')->where('title', $yuanxi[$i])->get();
                if (count($aa) == 0) {
                    DB::table('departments')->insertGetId($yuanxisql);
                }
            }

            /* 导入班级 */



            /* 导入学生 */
            $arr_userlist = []; //已存在的学生数组列表
            for ($i = 1; $i < $n; $i++) {
                $dd = DB::table('students')->where('mycode', $results[$i][0])->first();
                if ($dd) {
                    //$suctip[] = '<a href="' . $this->currentcontroller . '">返回学生管理</a>';
                    //return ( app('main')->jssuccess('学号为 ' . $results[$i][0] . ' 已存在,导入失败', $suctip));
//                            return redirect()->back()->withInput()->withSuccess('学号为 '. $results[$i][0].' 已存在,导入失败');
                    $arr_userlist[] = $results[$i][0];
                } else {
                    for ($i = 1; $i < $n; $i++) {
                        $s = 'insert into students (
mycode,
realname,
english_name,
gender,
grade,
educational_length,
project,
culture_level,
category,
dname,
major,
major_field,
entrance_time,
graduation_time,
management_department,
learning_form,
isbook,
isschool,
book_status,
administrative_class,
school_space,
note,
used_name,
national,
political_affiliation,
birth,
document_type,
mynumber,
orign_space,
national_area,
marital_status,
league_time,
hobbies,
myaccount,
mybank,
classname,
isdel ) values (';
                        $s .= '"' . $results[$i][0] . '",';
                        $s .= '"' . $results[$i][1] . '",';
                        $s .= '"' . $results[$i][2] . '",';
                        $s .= '"' . $results[$i][3] . '",';
                        $s .= '"' . $results[$i][4] . '",';
                        $s .= '"' . $results[$i][5] . '",';
                        $s .= '"' . $results[$i][6] . '",';
                        $s .= '"' . $results[$i][7] . '",';
                        $s .= '"' . $results[$i][8] . '",';
                        $s .= '"' . $results[$i][9] . '",';
                        $s .= '"' . $results[$i][10] . '",';
                        $s .= '"' . $results[$i][11] . '",';
                        $s .= '"' . $results[$i][12] . '",';
                        $s .= '"' . $results[$i][13] . '",';
                        $s .= '"' . $results[$i][14] . '",';
                        $s .= '"' . $results[$i][15] . '",';
                        $s .= '"' . $results[$i][16] . '",';
                        $s .= '"' . $results[$i][17] . '",';
                        $s .= '"' . $results[$i][18] . '",';
                        $s .= '"' . $results[$i][19] . '",';
                        $s .= '"' . $results[$i][20] . '",';
                        $s .= '"' . $results[$i][21] . '",';
                        $s .= '"' . $results[$i][22] . '",';
                        $s .= '"' . $results[$i][23] . '",';
                        $s .= '"' . $results[$i][24] . '",';
                        $s .= '"' . $results[$i][25] . '",';
                        $s .= '"' . $results[$i][26] . '",';
                        $s .= '"' . $results[$i][27] . '",';
                        $s .= '"' . $results[$i][28] . '",';
                        $s .= '"' . $results[$i][29] . '",';
                        $s .= '"' . $results[$i][30] . '",';
                        $s .= '"' . $results[$i][31] . '",';
                        $s .= '"' . $results[$i][32] . '",';
                        $s .= '"' . $results[$i][33] . '",';
                        $s .= '"' . $results[$i][34] . '",';
                        $s .= '"' . $results[$i][19] . '",';
                        $s .= '"' . '0' . '"';
                        $s .= ')';
                        $codeslist[] = $s;

//
                    }
//                        dd( $codeslist);
                    DB::transaction(function () use ($codeslist) {
                        foreach ($codeslist as $v) {
                            DB::statement($v);
                        }
                    });
                }
            }
            //$n = count($results);




            $banji = DB::table('students')->groupby('administrative_class')->pluck('administrative_class')->toarray();
            $bn = count($banji);
            for ($j = 0; $j < $bn; $j++) {
                $s = 'insert into classes (title,dname,isdel ) values (';
                $dd = DB::table('students')->where('administrative_class', $banji[$j])->first();
                $s .= '"' . $banji[$j] . '",';
                $s .= '"' . $dd->dname . '",';
                $s .= '"' . '0' . '"';
                $s .= ')';
                $codeslist1[] = $s;
            }
            DB::transaction(function () use ($codeslist1) {
                foreach ($codeslist1 as $v) {
                    DB::statement($v);
                }
            });


            return redirect()->back()->withInput()->withSuccess('导入成功！');

            //$suctip[] = '<a href="' . $this->currentcontroller . '">返回学生管理</a>';
            //return ( app('main')->jssuccess('操作成功', $suctip));
        });

//        }else{
//            dd('上传失败');
//        }
    }

    /* 导入学生 */

    public function import() {
        return view($this->viewfolder . '.import', ['j' => $this->j]);
    }

    public function doimport(Request $request) {
        ini_set('max_execution_time', '0');
        ini_set('memory_limit', '1024M');

        $filepath = $request->attachmentsurl;
        //$filepath = substr($filepath, 1, (strlen($filepath)-1) );
        //base_path().'/resources/views/init.blade.php'

        /* 检测文件是否存在 */


        if (@!copy(public_path($filepath), 'upload/files/student.xlsx')) {

            return redirect()->back()->withInput()->withErrors('导入失败，请重新上传');
        }
        unlink(public_path($filepath));

        //echo $filepath;
        //die;
        //$filePath = 'excel/student/201712/2.xlsx';
        $filepath = 'upload/files/student.xlsx';


        $results = Excel::load($filepath)->getSheet(0)->toArray();





//            dd($results);
        if (empty($results)) {
            return redirect()->back()->withInput()->withErrors('导入文件格式错误,导入失败');
        }



        $num = count($results[0]);
        if ($num != 35) {
            return redirect()->back()->withInput()->withErrors('导入文件格式错误,导入失败');
        }


        $n = count($results);

        /* 导入院系 */
        $this->importyuanxi($results);

        /* 导入班级 */
        $this->importclass($results);

        $classes = DB::table('classes')
                ->select('mycode', 'dic', 'title')
                ->get();

        $date = date('Y-m-d H:i:s');
        $upass = bcrypt('123456');

        /* 导入学生 */
        $arr_userlist = []; //已存在的学生数组列表
        $codeslist = []; // 

        for ($i = 1; $i < $n; $i++) {
            $dd = DB::table('students')->where('mycode', $results[$i][0])->first();
            if ($dd) {
                //$suctip[] = '<a href="' . $this->currentcontroller . '">返回学生管理</a>';
                //return ( app('main')->jssuccess('学号为 ' . $results[$i][0] . ' 已存在,导入失败', $suctip));
//                            return redirect()->back()->withInput()->withSuccess('学号为 '. $results[$i][0].' 已存在,导入失败');
                $arr_userlist[] = $results[$i][0];
            } else {
                $classname = $results[$i][19];
                foreach ($classes as $v) {

                    if ($classname == $v->title) {
                        $dic = $v->dic;
                        $classic = $v->mycode;
                        break;
                    } else {
                        $dic = 0;
                        $classic = 0;
                    }
                }

                $s = $this->getinsertsql($results[$i], $dic, $classic, $classname, $upass, $date);

                $codeslist[] = $s; //             
            }
        }

        if (count($codeslist) > 0) {
            DB::transaction(function () use ($codeslist) {
                foreach ($codeslist as $v) {
                    DB::statement($v);
                }
            });
        }




        return redirect()->back()->with('sucinfo', '导入成功！');
    }

    function getinsertsql(&$results, $dic, $classic, $classname, $upass, $date) {
        $s = 'insert into students (
                            dic,
                            classic,
                            classname,
mycode,
realname,
english_name,
gender,
grade,
educational_length,
project,
culture_level,
category,
dname,
major,
major_field,
entrance_time,
graduation_time,
management_department,
learning_form,
isbook,
isschool,
book_status,
administrative_class,
school_space,
note,
used_name,
national,
political_affiliation,
birth,
document_type,
mynumber,
orign_space,
national_area,
marital_status,
league_time,
hobbies,
myaccount,
mybank,
isdel,
upass,
created_at) values (';
        $s .= '"' . $dic . '",';
        $s .= '"' . $classic . '",';
        $s .= '"' . $classname . '",';
        $s .= '"' . $results[0] . '",';
        $s .= '"' . $results[1] . '",';
        $s .= '"' . $results[2] . '",';
        $s .= '"' . $results[3] . '",';
        $s .= '"' . $results[4] . '",';
        $s .= '"' . $results[5] . '",';
        $s .= '"' . $results[6] . '",';
        $s .= '"' . $results[7] . '",';
        $s .= '"' . $results[8] . '",';
        $s .= '"' . $results[9] . '",';
        $s .= '"' . $results[10] . '",';
        $s .= '"' . $results[11] . '",';
        $s .= '"' . $results[12] . '",';
        $s .= '"' . $results[13] . '",';
        $s .= '"' . $results[14] . '",';
        $s .= '"' . $results[15] . '",';
        $s .= '"' . $results[16] . '",';
        $s .= '"' . $results[17] . '",';
        $s .= '"' . $results[18] . '",';
        $s .= '"' . $results[19] . '",';
        $s .= '"' . $results[20] . '",';
        $s .= '"' . $results[21] . '",';
        $s .= '"' . $results[22] . '",';
        $s .= '"' . $results[23] . '",';
        $s .= '"' . $results[24] . '",';
        $s .= '"' . $results[25] . '",';
        $s .= '"' . $results[26] . '",';
        $s .= '"' . $results[27] . '",';
        $s .= '"' . $results[28] . '",';
        $s .= '"' . $results[29] . '",';
        $s .= '"' . $results[30] . '",';
        $s .= '"' . $results[31] . '",';
        $s .= '"' . $results[32] . '",';
        $s .= '"' . $results[33] . '",';
        $s .= '"' . $results[34] . '",';
        $s .= 0 . ',';
        $s .= '"' . $upass . '",';
        $s .= '"' . $date . '"';
        $s .= ')';

        return $s;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $xueyuanlist = app('main')->getxueyuanlist();
        $classlist = app('main')->getclasslist();

        $this->j['xueyuanlist'] = $xueyuanlist;
        $this->j['classlist'] = $classlist;

        $data = DB::table($this->dbname)
                ->where('id', $id)
                ->first();

        $this->j['data'] = $data;

        return view($this->viewfolder . '.edit', ['j' => $this->j]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $base = $this->getbase($request);
        $rules = $base->rules;
        $attributes = $base->attributes;

        $myrules = array();
        $myattributes = array();


        $rules = array_merge($base->rules, $myrules);
        $attributes = array_merge($base->attributes, $myattributes);



        $validator = Validator::make(
                        $request->all(), $rules, array(), $attributes
        );

        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        $mdb = $this->basemdb($request);

        if (!$mdb->m->isEmpty()) {
            return ( app('main')->ajaxvali($mdb->m->toArray()) );
        }

        $rs = $mdb->rs;




        DB::table($this->dbname)
                ->where('id', $id)
                ->update($rs);

        $suctip[] = '<a href="' . $this->currentcontroller . '">返回学生管理</a>';
        return ( app('main')->jssuccess('操作成功', $suctip));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        DB::beginTransaction();
        try {
            $deleteic = DB::table($this->dbname)
                    ->where('id', $id)
                    ->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect()->back()->withInput()->withSuccess('删除成功！');
    }

    public function savepass(Request $request) {
        $id = app('main')->rid('id');

        $rules = array(
            'upass' => 'required|string',
            'upass2' => 'required|string'
        );

        $attributes = array(
            'upass' => '密码',
            'upass2' => '确认密码'
        );

        $message = array(
        );

        $validator = Validator::make(
                        $request->all(), $rules, $message, $attributes
        );


        if ($validator->fails()) {
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }


        /* 验证密码 */
        if ($request->upass !== $request->upass2) {
            $validator->errors()->add('error2', '验证密码错误！');
            return ( app('main')->ajaxvali($validator->errors()->toArray()) );
        }

        /**/
        $rs['upass'] = bcrypt($request->upass);


        DB::table($this->dbname)->where('id', $id)->update($rs);

        $suctip[] = '<a href="' . $this->currentcontroller . '">返回学生管理</a>';
        return ( app('main')->jssuccess('保存成功', $suctip));
    }

    /* 导入院系 */

    function importyuanxi(&$list) {
        $n = count($list);

        /* 提取出原有院系 */
        $old_yuanxi = DB::table('departments')
                ->pluck('title')
                ->toarray();

        for ($i = 1; $i < $n; $i++) {
            if (!in_array($list[$i][9], $old_yuanxi)) {
                $old_yuanxi[] = $list[$i][9];

                $ic = app('main')->getfirstic();
                $yuanxisql['ic'] = $ic;
                $yuanxisql['title'] = $list[$i][9];
                $yuanxisql['isxueyuan'] = 1;
                $yuanxisql['cls'] = 100;
                $yuanxisql['isdel'] = 0;
                $yuanxisql['mytype'] = 'yewu';



                DB::table('departments')->insertGetId($yuanxisql);
            }
        }
    }

    function importclass(&$list) {
        $codeslist = [];

        $old_class = DB::table('classes')
                ->pluck('title')
                ->toarray();
        if (!$old_class) {
            $old_class = [];
        }

        $departments = DB::table('departments')
                ->select('ic', 'title')
                ->get();

        $n = count($list);

        for ($i = 1; $i < $n; $i++) {
            $dname = $list[$i][9];
            $classname = $list[$i][19];


            if (!in_array($classname, $old_class)) {

                $old_class[] = $classname;

                /* 取dic */


                foreach ($departments as $v) {
                    if ($v->title == $dname) {
                        $dic = $v->ic;
                        break;
                    } else {
                        $dic = 0;
                    }
                }

                $s = 'insert into classes (mycode,title,dic,dname,cls,isdel ) values (';
                $s .= '"' . app('main')->getfirstic() . '",';
                $s .= '"' . $classname . '",';
                $s .= '"' . $dic . '",';
                $s .= '"' . $dname . '",';
                $s .= 100 . ',';
                $s .= 0;
                $s .= ')';
                $codeslist[] = $s;
            }
        }


        if (count($codeslist) > 0) {
            DB::transaction(function () use ($codeslist) {
                foreach ($codeslist as $v) {
                    DB::statement($v);
                }
            });
        }
    }

}
