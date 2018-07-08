<?php

/* 在活动，课程，履职，校内，校外荣誉加联系人姓名 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertContactuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity', function ($table) {
            $table->string('conname', 20)->after('contel')->comment('联系人姓名');
        });
        Schema::table('courses', function ($table) {
            $table->string('conname', 20)->after('contel')->comment('联系人姓名');
        });
        Schema::table('innerhonor', function ($table) {
            $table->string('conname', 20)->after('contel')->comment('联系人姓名');
        });
        Schema::table('outerhonor', function ($table) {
            $table->string('conname', 20)->after('contel')->comment('联系人姓名');
        });
        Schema::table('perform', function ($table) {
            $table->string('conname', 20)->after('contel')->comment('联系人姓名');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('activity', function ($table) {
            $table->dropColumn(['conname']);
        });
        Schema::table('courses', function ($table) {
            $table->dropColumn(['conname']);
        });
        Schema::table('innerhonor', function ($table) {
            $table->dropColumn(['conname']);
        });
        Schema::table('outerhonor', function ($table) {
            $table->dropColumn(['conname']);
        });
        Schema::table('perform', function ($table) {
            $table->dropColumn(['conname']);
        });
    }
}
