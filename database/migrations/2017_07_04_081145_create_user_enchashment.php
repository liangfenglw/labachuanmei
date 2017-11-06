<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEnchashment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('user_account_log', 'pay_type')) {
            //
            Schema::table('user_account_log', function ($table) {
                $table->string('pay_type')->comment('消费方式');
            });
        }

        if (!Schema::hasColumn('user_account_log', 'pay_user')) {
            //
            Schema::table('user_account_log', function ($table) {
                $table->string('pay_user')->comment('消费账号');
            });
        }

        if (!Schema::hasTable('user_enchashment')) {
            Schema::create('user_enchashment', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id')->comment('用户id');
                $table->decimal('user_money',10,2)->default('0.00')->comment('用户金额');
                $table->string('pay_type')->comment('消费方式');
                $table->string('pay_user')->comment('消费账号');
                $table->string('desc')->comment('描述');
                $table->string('order_sn')->nullable()->comment('订单编号');
                $table->integer('order_id')->nullable()->comment('订单id');
                $table->tinyInteger('status')->default(0)->comment('状态，1已到账,0未到账');
                $table->tinyInteger('is_read')->default(0)->comment('阅读状态，1已读,0未读');
                $table->timestamps();
                // $table->timestamp('created_at')comment('添加时间')->nullable();
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
