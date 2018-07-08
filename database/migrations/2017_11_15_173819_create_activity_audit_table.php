<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_audit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('activityic', 50)->comment('活动ic');
            $table->string('myeventv', 50)->comment('操作');
            $table->string('myexplain', 50)->comment('说明 ');
            $table->string('aucode', 50)->comment('审核人工号');
            $table->string('auname', 50)->comment('审核人姓名');
            $table->integer('created_time')->comment('审核时间');
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
        Schema::drop('activity_audit');
}
}
