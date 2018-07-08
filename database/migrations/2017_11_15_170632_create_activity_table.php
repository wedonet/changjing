<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ic', 20);
            $table->string('title', 50);
            $table->string('activity_year', 50);
            $table->string('typeic', 50);
            $table->string('type_oneic', 50);
            $table->string('type_twoic', 50);
            
            $table->string('type_onename', 50);
            $table->string('type_twoname', 50);
            $table->string('mylevel', 50);
            $table->integer('mytimelong');
            $table->integer('mycredit');
            $table->integer('plantime_one');
            $table->integer('plantime_two');
            $table->integer('signuptime_one');
            $table->integer('signuptime_two');
            $table->string('sponsor', 50);
            $table->string('myplace', 255);
            $table->string('preimg', 500);
            $table->string('readme', 500);
            $table->text('content');
            
            $table->integer('homework');
            $table->integer('homeworktime_one');
            $table->integer('homeworktime_two');
            $table->integer('signlimit');
            
            $table->integer('signcount');
            $table->integer('checkcount');
            $table->integer('herecount');
            
            
            $table->string('mywayic', 50);
            $table->string('mywayname', 50);
            $table->string('other', 255);
            $table->string('attachmentsurl', 255);
            $table->string('originname', 50)->comment('原始文件名');
            
            $table->integer('isopen');
            $table->string('sucode', 50)->comment('发布人登录名');
            $table->string('suname', 50);
            $table->string('sdic')->comment('发布机构代码');
           
            $table->string('auditstatus', 50);
            $table->string('aucode', 50);
            $table->string('auname', 50);
            $table->integer('audittime');
            $table->string('signcode', 50);
            
            $table->string('currentstatus', 50);
            $table->integer('appraise')->comment('活动平均评价'); 
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
        Schema::drop('activity');
    }
}
