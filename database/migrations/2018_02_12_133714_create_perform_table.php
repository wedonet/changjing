<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('perform', function (Blueprint $table) {
            $table->increments('id');

            $table->string('sucode', 50)->comment('submit user code 所属人');
            $table->string('ucode', 50)->comment('所属学生学号');
            $table->string('realname', 50)->comment('姓名');
            $table->string('title', 50)->comment('职务');
            $table->string('myyear', 50)->comment('履职学年');

            $table->string('type_oneic', 50)->comment('一级类型ic');
            $table->string('type_twoic', 50)->comment('二级类型ic');

            $table->string('type_onename', 50)->comment('一级类型名称');
            $table->string('type_twoname', 50)->comment('二级类型名称');


            $table->string('mydic', 50)->comment('聘任部门ic');
            $table->string('mydname', 50);

            $table->integer('mycredit')->comment('学分');
            $table->integer('actualcredit')->comment('实得学分');




            $table->integer('isok')->default(0)->comment('是否通过');
            $table->string('isokucode', 50)->nullable()->comment('辅导员code');
            $table->integer('isoktime')->default(0);
            $table->text('notokreason')->comment('未通过原因)');
            
            $table->string('okway')->comment('审核通过途径，分为自动通过和牵头部门审核');
            
            
            $table->tinyInteger('isdel')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('perform');
    }

}
