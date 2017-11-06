<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderAppeal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单申诉表
        if (!Schema::hasTable('order_appeal')) {
            Schema::create('order_appeal', function (Blueprint $table) {
                $table->increments('id');
                $table->string('order_id', 30)->unique()->comment('子订单id');
                $table->string('order_sn', 30)->comment('订单号');
                $table->integer('supp_user_id')->index()->comment("供应商id");
                $table->integer('ads_user_id')->index()->comment("广告主id");
                $table->integer('type_id')->comment('活动类型id');
                $table->string('type_name')->nullable()->comment('活动类型(订单类型)');
                $table->string('title',200)->comment('活动名称');
                $table->string("success_url",200)->nullable()->comment('完成连接');
                $table->string('success_pic',200)->nullable()->comment('完成截图');
                $table->string('appeal_title',200)->comment('申诉标题');
                $table->text("content")->nullable()->comment('申诉内容');
                $table->tinyInteger('order_type')->default(0)->comment('订单状态0未完成1已完成');
                $table->text('order_feedback')->nullable()->comment('申诉反馈');
                $table->integer('admin_id')->nullable()->comment("管理员操作id");

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
