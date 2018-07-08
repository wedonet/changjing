<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesHourTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('courses_hour', function (Blueprint $table) {
            $table->increments('id');
            $table->string('courseic', 20)->comment('课程ic');
            $table->integer('coursenum')->comment('IC');
            $table->string('signcode', 50)->comment('签到码');
            $table->integer('start_time');
            $table->integer('finish_time');
            $table->string('myplace', 255)->comment('地点');
            $table->integer('signincount')->comment('签到人数');
            $table->integer('signoffcount')->comment('签退人数');
            
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('courses_hour');
    }

}
