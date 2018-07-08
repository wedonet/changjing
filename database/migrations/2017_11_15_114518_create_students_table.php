<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('realname', 50)->comment('姓名');
            $table->string('mycode', 50)->comment('学号')->unique();
         
            $table->string('dic', 50)->comment('学院编号');
            $table->string('dname', 50)->comment('学院名称');
            
            $table->string('classic', 50)->comment('班级编号');
            $table->string('classname', 50)->comment('班级名称');
            
            $table->string('mobile', 50)->comment('手机号');
            
            $table->string('gender', 50)->comment('性别');
            
            $table->string('email', 50)->comment('邮箱');
            
            $table->string('upass', 255)->comment('密码');         
            
            $table->string('english_name', 50);   
            //$table->string('gender', 50);   
            $table->string('grade', 50);   
            $table->string('educational_length', 50);   
            $table->string('project', 50);   
            $table->string('culture_level', 50);   
            $table->string('category', 50);   
            //$table->string('dname', 50);   
            $table->string('major', 50);   
            $table->string('major_field', 50);   
            $table->string('entrance_time', 50);   
            $table->string('graduation_time', 50);   
            $table->string('management_department', 50);   
            $table->string('learning_form', 50);   
            $table->string('isbook', 50);   
            $table->string('isschool', 50);   
            $table->string('book_status', 50);   
            $table->string('administrative_class', 50);   
            $table->string('school_space', 50);   
            $table->string('note', 50);   
            $table->string('used_name', 50);   
            $table->string('national', 50);   
            $table->string('political_affiliation', 50);   
            $table->string('birth', 50);   
            $table->string('document_type', 50);   
            $table->string('mynumber', 50);   
            $table->string('orign_space', 50);   
            $table->string('national_area', 50);   
            $table->string('marital_status', 50);   
            $table->string('league_time', 50);   
            $table->string('hobbies', 50);   
            $table->string('myaccount', 50);   
            $table->string('mybank', 50);   

            
       
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
        Schema::drop('students');
    }
}
