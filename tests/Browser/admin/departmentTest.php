<?php

namespace Tests\Browser\admin;

use Tests\TestCase;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Repositories\testdata\user as user;
use Tests\Browser\Pages\adminlogin;

class departmentTest extends DuskTestCase {

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testdepartment() {
        $this->browse(function ($browser) {
            $browser->visit(new adminlogin)
                    ->login();
            
//            $browser->visit('/adminconsole/department')
//                    ->assertSee('部门管理'); //list页正常
//
//            /* 添加部门 */
//            $str = time();
//            
//
//            /* 添加业务部门， 是学院 */
//            $browser->visit('adminconsole/department/create')
//                    ->assertSee('添加部门') //create 页正常
//                    ->type('title', 'department' . $str)
//                    ->type('ic', 'ic' . $str)
//                    ->select('mytype', 'yewu')
//                    ->select('isxueyuan', '1')
//                    ->press('submit')
//                    ->waitForText('成功')
//                    ->assertSee('成功');
                      

            
        });
    }

}
