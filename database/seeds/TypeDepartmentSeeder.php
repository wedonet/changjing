<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TypeDepartmentSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        //二级分类和部门的关联关系 
        $relation = array(
            'ds' => 'xsgzb',
            'dz' => 'tw',
            'yx' => 'jwc',
            'yz' => 'zsjyc',
            'zc' => 'xsgzb',
            'zz' => 'tw',
            'wg' => 'tw',
            'wt' => 'xsgzb',
            'qcxcy' => 'zsjyc',
            'qcxsy' => 'tw',
            'jy' => 'tw',
            'js' => 'xsgzb'
        );




        foreach ($relation as $key => $v) {
            $data = DB::table('departments')
                    ->where('ic', $v)
                    ->first();

            $rs = [];
            $rs['qiantouic'] = $v;
            $rs['qiantouname'] = $data->title;

            DB::table('activity_type')
                    ->where('ic', $key)
                    ->update($rs);
        }

        Model::reguard();
    }

    
}
