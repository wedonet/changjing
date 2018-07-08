<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loginhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gic', 50)->comment('用户组');
            $table->string('dic', 50)->comment('部门编码');
            $table->string('roleic', 50)->comment('角色');
            $table->string('ip', 30);
            $table->integer('ctime');
            $table->string('uname', 50)->comment('登录名');
            


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('loginhistory');
    }
}
