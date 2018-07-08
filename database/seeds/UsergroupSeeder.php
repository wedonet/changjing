<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usergroup as Usergroup;

class UsergroupSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();
        /* 添加管理员用户组 */
        $data = Usergroup::firstOrNew(['ic' => 'admin']);
        $data->ic = 'admin';
        $data->title = '管理员';
        $data->cls = 90;
        $data->issys = 1;
        $data->isuse = 1;
        $data->counters = 1;
        $data->mytype = 'group';
        $data->pid = 0;

        $data->save();

        /* 如果是刚插入的用户组，则再插入一个超级管理员的角色 */
        if ($data->wasRecentlyCreated) {
            $datarole = Usergroup::firstOrNew(['ic' => 'supper', 'pid' => $data->id]);

            $datarole->ic = 'supper';
            $datarole->title = '超级管理员';
            $datarole->cls = 90;
            $datarole->issys = 1;
            $datarole->isuse = 1;
            $datarole->counters = 0;
            $datarole->mytype = 'role';
            $datarole->pid = $data['id'];
            $datarole->save();
        }





        unset($data);
        /* 添加商家用户组 */
        $data = Usergroup::firstOrNew(['ic' => 'biz']);

        $data->ic = 'biz';
        $data->title = '商家';
        $data->cls = 92;
        $data->issys = 1;
        $data->isuse = 1;
        $data->counters = 0;
        $data->mytype = 'group';
        $data->pid = 0;

        $data->save();
        /* 如果是刚插入的商家用户组，则再插入一个管理员的角色 */
        if ($data->wasRecentlyCreated) {
            $datarole = Usergroup::firstOrNew(['ic' => 'sup', 'pid' => $data->id]);

            $datarole->ic = 'sup';
            $datarole->title = '管理员';
            $datarole->cls = 90;
            $datarole->issys = 1;
            $datarole->isuse = 1;
            $datarole->counters = 0;
            $datarole->mytype = 'role';
            $datarole->pid = $data['id'];

            $datarole->save();
        }
        unset($data);

        /* 添加游客 */
        $data = Usergroup::firstOrNew(['ic' => 'guest']);

        $data->ic = 'guest';
        $data->title = '游客';
        $data->cls = 94;
        $data->issys = 1;
        $data->isuse = 1;
        $data->counters = 0;
        $data->mytype = 'group';
        $data->pid = 0;
        $data->save();
        Model::reguard();
    }

}
