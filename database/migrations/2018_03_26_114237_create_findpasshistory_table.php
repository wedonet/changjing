<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFindpasshistoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('findpasshistory', function (Blueprint $table) {
            $table->increments('id');

            $table->string('mycode', 50)->comment('学号');
            $table->string('mynumber', 50)->comment('身份证号');
            $table->string('realname', 50)->comment('姓名');            
            
            $table->string('ip', 50)->comment('ip地址');
            $table->integer('ctime');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('findpasshistory');
    }

}
