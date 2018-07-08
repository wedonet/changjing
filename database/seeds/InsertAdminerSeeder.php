<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Adminuser as Adminuser;


class InsertAdminerSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = Adminuser::firstOrNew(['uname' => 'admin']);
        
        $data->upass = bcrypt('Wy_Admin123456');
        $data->save();    

        //Model::unguard();       


        /* 添加管理员用户 */
//        $data = User::firstOrNew(['u_name' => 'wedonet']);
//        $data->u_gic = 'admin';
//        $data->u_gname = '管理员';
//        $data->u_rolename = '超级管理员';
//        $data->u_roleic = 'supper';
//
//
//        $data->u_name = 'wedonet';
//        $data->u_pass = bcrypt('123456');
//        $data->u_mail = '16216077@qq.com';
//
//        $data->u_mobile = '13043272481';
//
//        $data->u_nick = '超级管理员';
//        $data->u_fullname = 'WeDoNet';
//
//        $data->suid = 0;
//        $data->euid = 0;
//
//        $data->ischeckd = 1;
//        $data->islocked = 0;
//        $data->save();

        /* 添加管理员口令 */
//        unset($data);
//        $data = Adminuser::firstOrNew(['u_name' => 'wedonet']);
        //       $data->u_name = 'wedonet';
        //       $data->u_pass = bcrypt('123456');
        //       $data->save();
        //Model::reguard();
    }

}
