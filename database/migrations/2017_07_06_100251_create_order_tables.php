<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单主表
        if (!Schema::hasTable('order')) {
            Schema::create('order', function (Blueprint $table) {
                $table->increments('id');
                $table->string('order_id', 30)->unique()->comment('订单id');
                $table->integer('ads_user_id')->index()->comment("广告主id");
                $table->tinyInteger('order_type')->default(1)->comment('订单状态1预约状态(等待接受)2拒绝3流单4正执行5完成');
                $table->string('title',200)->comment('活动标题');
                $table->integer('type_id')->comment('活动类型id');
                $table->integer('type_name')->comment('活动类型(订单类型)');
                $table->decimal('user_money',10,2)->default('0.00')->comment('消费总金额');
                $table->timestamp('start_at')->nullable();
                $table->timestamp('over_at')->nullable();
                $table->timestamps();
            });
        }
        //子订单表-网络媒体TODO:此处应该再分表
        if (!Schema::hasTable('order_network')) {
            Schema::create('order_network', function (Blueprint $table) {
                $table->increments('id');
                $table->string('order_id', 30)->unique()->comment('主订单id');
                $table->integer('supp_user_id')->index()->comment("供应商id");
                $table->tinyInteger('order_type')->default(1)->comment('订单状态1预约状态(等待接受) 2拒绝 3流单 4正执行(接受) 5供应商完成 6供应商反馈 7广告主反馈 8广告主质量反馈 9申诉中 10广告主确认完成');
                $table->integer('type_id')->comment('活动类型id');
                $table->integer('type_name')->nullable()->comment('活动类型(订单类型)');
                $table->tinyInteger('doc_type')->nullable()->comment("1外部链接2上传文档3内部编辑");
                $table->text("content")->nullable()->comment('文档内容');
                $table->string("keywords",200)->nullable()->comment('关键词');
                $table->text("remark")->nullable()->comment('备注');
                $table->decimal('user_money',10,2)->nullable()->default('0.00')->comment('消费总金额');
                $table->tinyInteger('qa_feedback')->nullable()->comment("质量反馈1优2中3差");
                $table->string("success_url",200)->nullable()->comment('完成连接');
                $table->string('success_pic',200)->nullable()->comment('完成截图');
                $table->text('order_feedback')->nullable()->comment('订单反馈');
                $table->text('supp_feedback')->nullable()->comment('供应商反馈');
                $table->decimal('qa_change',10,2)->nullable()->comment('质量扣款');
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
