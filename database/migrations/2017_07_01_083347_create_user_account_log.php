<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_account_log')) {
            Schema::create('user_account_log', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id')->comment('用户id');
                $table->decimal('user_money',10,2)->default('0.00')->comment('用户金额');
                $table->tinyInteger('account_type')->comment('金额类型,1充值2消费3提现');
                $table->string('desc')->comment('描述');
                $table->string('order_sn')->nullable()->comment('订单编号');
                $table->integer('order_id')->nullable()->comment('订单id');
                $table->timestamps();
                // $table->timestamp('created_at')comment('添加时间')->nullable();
            });
        }

        if (!Schema::hasColumn('ad_users', 'user_money')) {
            //
            Schema::table('ad_users', function ($table) {
                $table->decimal('user_money',10,2)->default('0.00')->comment('用户金额');
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
