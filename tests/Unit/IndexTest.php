<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasic1Test() {
        $response = $this->get('/');

        $response->assertStatus(200);

       


    }

}
