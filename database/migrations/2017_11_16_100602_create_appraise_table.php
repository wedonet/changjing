<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppraiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraise', function (Blueprint $table) {
            $table->increments('id');
            $table->string('activityic', 20);
            $table->integer('myvalue');
            $table->string('ucode', 50);
            $table->string('mymodule',20)->comment('评价模块');
            $table->integer('appraise_time')->comment('评价时间');
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
        Schema::drop('appraise');
    }
}
