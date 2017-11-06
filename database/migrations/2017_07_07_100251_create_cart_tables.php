<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //购物车主表
        if (!Schema::hasTable('cart')) {
            Schema::create('cart', function (Blueprint $table) {
                $table->increments('id');
                $table->string('order_sn', 30)->unique()->comment('订单编号');
                $table->integer('ads_user_id')->index()->comment("广告主id");
                $table->string('title',200)->comment('活动标题');
                $table->integer('type_id')->comment('活动类型id');
                $table->string('type_name',200)->nullable()->comment('活动类型(订单类型)');
                $table->decimal('user_money',10,2)->default('0.00')->comment('消费总金额');
                $table->tinyInteger('doc_type')->nullable()->comment("1外部链接2上传文档3内部编辑");
                $table->text("content")->nullable()->comment('文档内容');
                $table->string("keywords",200)->nullable()->comment('关键词');
                $table->text("remark")->nullable()->comment('备注');
                $table->tinyInteger('is_delete')->default(1)->comment('订单删除状态1默认(不操作)2删除');
                $table->tinyInteger('status')->default(0)->comment('订单支付状态0未支付1已支付(等待状态)2支付成功');
                $table->timestamp('start_at')->nullable();
                $table->timestamp('over_at')->nullable();
                $table->timestamps();
            });
        }
        //子购物车表-网络媒体TODO:此处应该再分表
        if (!Schema::hasTable('cart_network')) {
            Schema::create('cart_network', function (Blueprint $table) {
                $table->increments('id');
                $table->string('order_sn', 30)->comment('主订单编号');
                $table->integer('supp_user_id')->index()->comment("供应商id");
                $table->integer('type_id')->comment('活动类型id');
                $table->string('type_name',200)->nullable()->comment('活动类型(订单类型)');
                $table->string('screen_attr_value_ids')->nullable()->comment('用户下单时候筛选的相关属性值');
                $table->decimal('user_money',10,2)->nullable()->default('0.00')->comment('消费总金额');
                $table->tinyInteger('is_delete')->default(1)->comment('订单删除状态1默认(不操作)2删除,冗余字段');
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
