<?php

/* 在活动，课程，履职，校内，校外荣誉加联系电话 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertTel extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('activity', function ($table) {
            $table->string('contel', 20)->after('isdel')->comment('联系电话');
        });
        Schema::table('courses', function ($table) {
            $table->string('contel', 20)->after('isdel')->comment('联系电话');
        });
        Schema::table('innerhonor', function ($table) {
            $table->string('contel', 20)->after('notokreason')->comment('联系电话');
        });
        Schema::table('outerhonor', function ($table) {
            $table->string('contel', 20)->after('notok2reason')->comment('联系电话');
        });
        Schema::table('perform', function ($table) {
            $table->string('contel', 20)->after('isdel')->comment('联系电话');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('activity', function ($table) {
            $table->dropColumn(['contel']);
        });
        Schema::table('courses', function ($table) {
            $table->dropColumn(['contel']);
        });
        Schema::table('innerhonor', function ($table) {
            $table->dropColumn(['contel']);
        });
        Schema::table('outerhonor', function ($table) {
            $table->dropColumn(['contel']);
        });
        Schema::table('perform', function ($table) {
            $table->dropColumn(['contel']);
        });
    }

}
