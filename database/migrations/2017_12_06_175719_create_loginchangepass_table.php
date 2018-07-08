<?php
/*首次登录修改密码*/
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginchangepassTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('loginchangepass', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gic', 50)->comment('用户组');
            $table->string('roleic', 50)->comment('角色');
            $table->string('uname', 50)->comment('登录名');


            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('loginchangepass');
    }

}
