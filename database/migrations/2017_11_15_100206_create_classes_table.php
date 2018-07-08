<?php
/*生成班级表*/
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50)->comment('班级名称');
            $table->string('mycode', 50)->comment('班级编号');
            $table->string('dic', 20)->comment('所属部门IC');
            $table->string('dname', 50)->comment('所属部门');
            $table->string('masteric', 20)->comment('负责教师工号');
            $table->string('mastername', 20)->comment('负责教师姓名');
            $table->string('readme', 500)->comment('班级说明');
            $table->integer('cls');
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
        Schema::drop('classes');
    }
}
