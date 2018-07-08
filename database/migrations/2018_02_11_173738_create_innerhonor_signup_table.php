<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInnerhonorSignupTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('innerhonor_signup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mytype', 50)->comment('innerhonor');
            $table->string('itemic', 50)->comment('');    
            $table->string('ucode', 20)->comment('学号');
            $table->integer('signup_time')->comment('报名时间');            /**/        

            $table->integer('audited')->comment('审核时间');  
            $table->integer('isok')->comment('是否通过，通过的可以拿到学分,和上面的一样');
            $table->integer('plancredit')->comment('应得学分');
            $table->integer('actualcredit')->comment('实得学分');

            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('innerhonor_signup');
    }

}
