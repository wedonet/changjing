<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesSigninTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_signin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ucode',20)->comment('学号');
            $table->string('mytype',10)->comment('类型，in, off');
            $table->string('courseic', 20)->comment('课程ic');
            $table->integer('coursenumic')->comment('第几课ic');
            $table->integer('issignined');
            $table->integer('signintime');
            $table->integer('signoffedime');
            $table->integer('issignoffed');
            $table->string('ip',30);
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
        Schema::drop('courses_signin');
    }
}
