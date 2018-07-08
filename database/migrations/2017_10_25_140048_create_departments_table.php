<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('ic', 50)->comment('ic');
            $table->string('title', 50)->comment('名称');
            $table->string('mytype', 20)->comment('部门类型');
            $table->string('masteric', 50)->comment('负责人工号');
            $table->string('mastername', 20)->comment('负责人');

            $table->string('icfq', 20)->comment('发起人ic');
            $table->string('userfq', 20)->comment('发起人用户名');
            $table->string('namefq', 20)->comment('发起人名称');
            $table->string('passfq', 255)->comment('发起人密码');

            $table->string('icsh', 20)->comment('审核人ic');
            $table->string('usersh', 20)->comment('审核人用户名');
            $table->string('namesh', 20)->comment('审核人名称');
            $table->string('passsh', 255)->comment('审核人密码');

            $table->integer('cls')->comment('排序');
            $table->integer('isxueyuan')->comment('是否学院');

            $table->string('readme', 50)->comment('简介');

            $table->tinyInteger('isdel');

            $table->rememberToken();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('departments');
    }

}
