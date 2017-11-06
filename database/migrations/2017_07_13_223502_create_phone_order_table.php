<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('phone_order')) {
            Schema::create('phone_order', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->index()->comment('用户id');
                $table->string('contact_phone',20)->comment('联系电话');
                $table->tinyInteger('status')->default(2)->comment('1完成,2等待回拨');
                $table->integer('admin_id')->index()->nullable()->comment('操作人id');
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
