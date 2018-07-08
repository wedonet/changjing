<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminusersaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('adminusers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uname', 50)->comment('用户名');
            $table->string('upass', 60)->comment('口令');

            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('adminusers');
    }

}
