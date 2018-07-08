<?php

/* 管理员登录 */

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class adminloginTest extends DuskTestCase {

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample() {
        $user = (object) [];

        $user->uname = 'admin';
        $user->upass = 'Wy_Admin123456';

        /* 密码正确 */
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/adminlogin')
                    ->assertTitle('管理员登录')
                    ->type('uname', $user->uname)
                    ->type('upass', $user->upass)
                    ->press('#submit')
                    ->assertSee('登录成功');
        });

        /* 密码错误 */
        $user->upass = 'Admin123456';
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/adminlogin')
                    ->assertTitle('管理员登录')
                    ->type('uname', $user->uname)
                    ->type('upass', $user->upass)
                    ->press('#submit')
                    ->assertSee('错误提示');
        });
    }

}
