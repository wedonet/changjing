<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ic', 20);
            $table->string('title', 255);
            $table->string('activity_year', 50);
            $table->string('typeic', 50);
            $table->string('type_oneic', 50);
            $table->string('type_twoic', 50);

            $table->string('type_onename', 50);
            $table->string('type_twoname', 50);
            $table->string('department', 50);
            $table->string('mylevel', 50);
            $table->string('mytimelong', 50);
            $table->integer('mycredit');
            $table->integer('plantime_one');
            $table->integer('plantime_two');
            $table->integer('signuptime_one');
            $table->integer('signuptime_two');
            $table->string('sponsortype', 50)->comment('主办单位类型');
            $table->string('sponsor', 50);
            $table->string('myplace', 255);
            $table->string('preimg', 500);
            $table->string('readme', 255);
            $table->text('content');

            /**/
            $table->integer('homework');
            $table->integer('homeworktime_one');
            $table->integer('homeworktime_two');
            $table->integer('signlimit');


            $table->integer('signcount');
            $table->integer('checkcount');
            $table->integer('herecount');


            /**/
            $table->string('mywayic', 50);
            $table->string('mywayname', 50);
            $table->string('other', 255)->comment('备注');
            $table->string('attachmentsurl', 255)->comment('附件地址');
            $table->string('originname', 50)->comment('原始文件名');

            $table->tinyInteger('isopen');
            $table->string('sucode', 50)->comment('上传人工号');
            $table->string('suname', 50)->comment('上传人姓名');
            $table->string('sdic')->comment('发布机构代码');

            $table->string('auditstatus', 50)->comment('审核状态');
            $table->string('aucode', 50)->comment('审核工号');
            $table->string('auname', 50)->comment('审核人姓名');

            /**/
            $table->integer('audittime')->nullable();
            $table->string('signcode', 50)->comment('签到码');

            $table->string('currentstatus', 50);
            $table->integer('appraise')->comment('平均评价');
            $table->tinyInteger('isdel');


            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('courses');
    }

}
