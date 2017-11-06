<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('activity')) {
            Schema::create('activity', function (Blueprint $table) {
                $table->increments('id');
                $table->string('activity_name',200)->comment('活动名称');
                $table->timestamp('start')->nullable()->comment('开始时间');
                $table->timestamp('over')->nullable()->comment('结束时间');
                $table->string('plate_rate',10)->defalut(100)->comment('平台优惠率');
                $table->string('vip_rate',10)->defalut(100)->comment('vip会员优惠率');
                $table->tinyInteger('all')->defalut(1)->comment('1选择性2全体');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
