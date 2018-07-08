<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departments as Departments;
use App\Models\Teachers as Teachers;

class DepartmentsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        $v['ic'] = 'bgs';
        $v['title'] = '办公室';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;

        $v['ic'] = 'dwzzb';
        $v['title'] = '党委组织部';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'dwxcb';
        $v['title'] = '党委宣传部';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'jljcwyh';
        $v['title'] = '纪律检查委员会';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'xsgzb';
        $v['title'] = '学生工作部';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'lxtglc';
        $v['title'] = '离退休管理处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'fzghc';
        $v['title'] = '发展规划处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'rsc';
        $v['title'] = '人事处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'yjsy';
        $v['title'] = '研究生院';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'jwc';
        $v['title'] = '教务处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'zsjyc';
        $v['title'] = '招生就业处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'kyc';
        $v['title'] = '科研处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'gjhzyjlc';
        $v['title'] = '国际合作与交流处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'cwc';
        $v['title'] = '财务处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'hqglc';
        $v['title'] = '后勤管理处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'zcglc';
        $v['title'] = '资产管理处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'bwc';
        $v['title'] = '保卫处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'xxhjsbgs';
        $v['title'] = '信息化建设办公室';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'bhxqgwh';
        $v['title'] = '滨海校区管委会';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'gh';
        $v['title'] = '工会';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'tw';
        $v['title'] = '团委';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        $v['ic'] = 'xyzhmsc';
        $v['title'] = '校友总会秘书处';
        $v['mytype'] = 'zhineng';
        $v['isxueyuan'] = 0;
        $a[] = $v;


        foreach ($a as $v) {
            $data = Departments::firstOrNew(['title' => $v['title']]);

            $data->ic = $v['ic'];
            $data->title = $v['title'];

            $data->mytype = $v['mytype'];

            $data->icfq = app('main')->getfirstic();
            $data->userfq = $v['ic'] . '_fq';
            $data->namefq = '';
            $data->passfq = bcrypt('123456');

            $data->icsh = app('main')->getfirstic();
            $data->usersh = $v['ic'] . '_sh';
            $data->namesh = '';
            $data->passsh = bcrypt('123456');

            $data->cls = 100;
            $data->isxueyuan = $v['isxueyuan'];
            $data->isdel = 0;
            $data->created_at = date('Y-m-d H:i:s');


            $data->save();

            /* 添加进老师表 */
            $teacher = Teachers::firstOrNew(['mycode' => $data->userfq]);
            $teacher->mycode = $data->userfq;
            $teacher->mytype = 'fq';
            $teacher->dic = $v['ic'];
            $teacher->dname = $v['title'];
            $teacher->realname = '发起账号';
            $teacher->upass = $data->passfq;
            $teacher->isdel = 0;
            $teacher->created_at = date('Y-m-d H:i:s');

            $teacher->save();

            $teacher = Teachers::firstOrNew(['mycode' => $data->usersh]);
            $teacher->mycode = $data->usersh;
            $teacher->mytype = 'sh';
            $teacher->dic = $v['ic'];
            $teacher->dname = $v['title'];
            $teacher->realname = '审核账号';
            $teacher->upass = $data->passsh;
            $teacher->isdel = 0;
            $teacher->created_at = date('Y-m-d H:i:s');
            $teacher->save();
        }

        Model::reguard();
    }

}
