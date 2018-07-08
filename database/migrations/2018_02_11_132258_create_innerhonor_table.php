<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInnerhonorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('innerhonor', function (Blueprint $table) {
            $table->increments('id');

            $table->string('ucode', 50)->comment('所属人');

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

            $table->string('dic', 50)->comment('所在学院');
            $table->string('dname', 50)->comment('所在学院名称');

            $table->integer('hasstudent')->default(0)->comment('是否添加完人员了');
            $table->integer('isok')->default(0)->comment('是否通过');
            $table->string('isokucode', 50)->nullable()->comment('牵头部门code');
            $table->integer('isoktime')->default(0);
            $table->text('notokreason')->comment('牵头部门未通过原因');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('innerhonor');
    }

}
