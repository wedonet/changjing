<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mytype', 50)->comment('模块');
            $table->string('itemic', 50)->comment('记录的ic');
            $table->string('myeventv', 50)->comment('操作');
            $table->string('myexplain', 50)->comment('说明 ');
            $table->string('aucode', 50)->comment('审核人工号');
            $table->string('auname', 50)->comment('审核人姓名');
            $table->string('dic', 50)->comment('审核部门');
            $table->integer('ctime')->comment('审核时间');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('audit');
    }
}
