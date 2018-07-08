<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ic', 20);
            $table->string('title', 50);

            $table->string('readme', 255);
            $table->integer('mydepth')->comment('深度');

            $table->string('pic', 50)->comment('父级IC');
            $table->string('qiantouic', 50)->comment('牵头部门IC');

            $table->string('qiantouname', 50)->comment('牵头部门名称');
            
            $table->integer('target')->comment('目标学分');
            $table->integer('ismust')->comment('是否必修');

            $table->tinyInteger('isdel');
            $table->integer('cls');
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
        Schema::drop('activity_type');
    }
}
