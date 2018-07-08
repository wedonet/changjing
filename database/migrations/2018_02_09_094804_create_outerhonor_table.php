<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOuterhonorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outerhonor', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('ucode', 50)->comment('所属人');
            $table->string('dic', 50)->comment('所属部门，是哪个院系的');
            
            $table->string('title', 50)->comment('名称');
            $table->string('sponsor', 50)->comment('奖励单位');
            $table->integer('mydate')->comment('获奖日期');
            $table->integer('myvalue')->comment('奖励金额');
            $table->string('readme', 500)->comment('奖励说明');
            
            
            $table->string('attachmentsurl', 500)->nullable()->comment('奖励说明');
            $table->integer('mycredit')->comment('学分');
            $table->integer('actualcredit')->comment('实得学分');
   
       
            $table->string('type_oneic', 50)->comment('一级类型ic');
            $table->string('type_twoic', 50)->comment('二级类型ic');
            
            $table->string('type_onename', 50)->comment('一级类型名称');
            $table->string('type_twoname', 50)->comment('二级类型名称');
            
            $table->integer('isok1')->default(0)->comment('辅导员是否通过');
            $table->string('isok1ucode', 50)->nullable()->comment('辅导员code');
            $table->integer('isok1time')->default(0);
            $table->text('notok1reason')->comment('辅导员未参赛过原因，json(时间，原因)');
            $table->integer('isok2')->default(0)->comment('牵头部门是否通过');
            $table->integer('isok2time')->default(0);
            $table->string('isok2ucode', 50)->nullable()->comment('牵头部门code');
            $table->text('notok2reason')->comment('牵头部门未通过原因，json(时间，原因)');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outerhonor');
    }
}
