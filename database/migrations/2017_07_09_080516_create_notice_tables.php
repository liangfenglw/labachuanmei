<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('notice')) {
            Schema::create('notice', function (Blueprint $table) {
                $table->increments('id');
                $table->string('order_id', 30)->index()->comment('订单id');
                $table->integer('is_read')->default(2)->index()->comment("是否查看1查看2未查看");
                $table->integer('user_id')->comment('接收人');
                $table->string('content',200)->nullable()->comment('通知内容');
                $table->string('remark',200)->nullable()->comment('备注');
                $table->tinyInteger('type')->default(1)->nullable()->comment('1订单通知');
                $table->string('operaer',100)->nullable()->comment('操作人');
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
