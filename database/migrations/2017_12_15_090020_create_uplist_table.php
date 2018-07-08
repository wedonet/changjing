<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUplistTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('uplists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename', 50)->comment('用户名');
            $table->string('url', 50)->comment('地址');
            $table->string('originname', 50)->comment('原文件名');
            $table->string('uname', 50)->comment('上传人');
            $table->string('mytype', 50)->comment('文件类型');
            $table->string('ext', 50)->comment('后缀');
            $table->integer('mysize')->comment('大小，k');
            $table->integer('mywidth')->comment('width');
            $table->integer('myheight')->comment('height');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('uplists');
    }

}
