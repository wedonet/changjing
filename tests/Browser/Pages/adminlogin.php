<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class adminlogin extends BasePage {

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url() {
        return '/adminconsole';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser) {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements() {
        return [
            '@element' => '#selector',
        ];
    }

    public function login(Browser $browser) {
        $browser->visit('/adminlogin')
                ->type('uname', 'admin')
                ->type('upass', 'Wy_Admin123456')
                ->press('#submit');
    }

}
