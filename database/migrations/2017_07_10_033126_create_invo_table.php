<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('invo')) {
            Schema::create('invo', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('invo_type')->comment('1,收据，2普通发票，3专用发票');
                $table->integer('detail_type')->comment('未定，主要看配置');
                $table->integer('money_type')->comment("1充值金额，2消费金额");
                $table->decimal('money',10,2)->default('0.00')->comment('发票金额');
                $table->integer('send_type')->comment("发送方式,1电子档2纸质快递1000起");
                $table->integer('user_id')->index()->comment("用户id");
                $table->string('invoice_title',200)->nullable()->comment('发票抬头');
                $table->string('email',80)->nullable()->comment('邮箱地址');
                $table->string('address',200)->nullable()->comment('联系地址');
                $table->text("remark")->nullable()->comment('备注');
                $table->tinyInteger('is_delete')->default(1)->comment('订单删除状态1默认(不操作)2删除');
                $table->tinyInteger('status')->default(0)->comment('提现状态1未完成2已完成');
                $table->integer('admin_id')->nullable()->comment("管理员id,备用");
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
