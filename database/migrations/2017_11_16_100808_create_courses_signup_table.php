<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesSignupTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('courses_signup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mytype', 50)->comment('类型，活动activity,课程course');
            $table->string('itemic', 20);
            $table->string('ucode', 50);
            $table->integer('signup_time');
            $table->integer('audited');
            $table->string('mystate', 255);
            $table->string('auditstatus', 20)->comment('是否审核通过');
            $table->string('myexplain', 255);
            $table->integer('signnum')->comment('签到次数');
            $table->integer('homeworkisdone')->comment('是否完成作业');
            $table->integer('homeworkisok')->comment('做业是否通过');     
            $table->text('homeworkexplain')->comment('作业未通过原因');  
            $table->string('homeworkurl', 255);


            $table->integer('issignined')->comment('是否签到');
            $table->integer('signintime')->comment('签到时间');
            $table->integer('issignoffed')->comment('是否签退');
            $table->integer('signoffedime')->comment('签退时间');


            $table->integer('itemisok')->comment('课程是否通过，通过的可以拿到学分');    
            $table->integer('plancredit')->comment('应得学分');
            $table->integer('actualcreidt')->comment('实得学分');
            $table->integer('mylevel')->comment('学分等级');
            $table->string('creditexplain', 255)->comment('学分说明');            
            $table->integer('appraise')->default(0)->comment('评价');    
            $table->integer('appraisetime')->default(0)->comment('评价时间');  
            
      
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('courses_signup');
    }

}
