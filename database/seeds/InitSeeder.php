<?php

use Illuminate\Database\Seeder;


class InitSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        /* 添加默认用户组 */
        //$this->call(UsergroupSeeder::class);
        //$this->call(DistrictSeeder::class);


        /* 添加默认管理员 */
        $this->call(InsertAdminerSeeder::class);

        /* 部门 */
        $this->call(DepartmentsSeeder::class);

        /* 活动类型 */
        $this->call(ActivityTypeSeeder::class);
        
        /*更新部门和活动类型的关系*/
        $this->call(TypeDepartmentSeeder::class);
    }

}
