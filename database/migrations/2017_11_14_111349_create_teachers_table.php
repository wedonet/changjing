<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mycode', 20)->comment('教师编号');
            $table->string('mytype', 20)->comment('账号类型，fq,sh,空');
            $table->string('dic', 20)->comment('所属部门IC');
            $table->string('dname', 50)->comment('所属部门');
            $table->string('realname', 20)->comment('姓名');
            $table->string('upass', 255)->comment('密码');
            $table->tinyInteger('isdel');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teachers');
    }
}
