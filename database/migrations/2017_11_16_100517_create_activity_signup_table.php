<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitySignupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_signup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mytype', 50)->comment('类型，活动activity,课程course');
            $table->string('itemic', 50)->comment('activityic或courseic');
            $table->string('activityic', 50)->comment('活动ic');
            $table->string('ucode', 20)->comment('学号');
            $table->integer('signup_time')->comment('报名时间');
            /**/
            $table->string('mystate', 50)->comment('报名陈述');
            $table->string('auditstatus', 20)->comment('是否审核通过');
            $table->integer('audited')->comment('审核时间');
            $table->string('myexplain', 255)->comment('未通过说明');
            $table->integer('issignined')->comment('是否签到');
            /**/
            $table->integer('signintime')->comment('签到时间');
            $table->integer('issignoffed')->comment('是否签退');
            $table->integer('signoffedime')->comment('签退时间');
            $table->integer('homeworkisdone')->comment('是否完成作业');
            $table->integer('homeworkisok')->comment('做业是否通过');     
            
            $table->text('homeworkexplain')->comment('作业未通过原因');

            $table->string('homeworkurl', 255)->comment('作业下载地址');
            
            $table->integer('activityisok')->comment('活动是否通过，通过的可以拿到学分');    
            $table->integer('isok')->comment('活动是否通过，通过的可以拿到学分,和上面的一样');    
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
    public function down()
    {
        Schema::drop('activity_signup');
    }
}
