<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAdUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('ad_users', 'parent_id')) {
            Schema::table('ad_users', function (Blueprint $table) {

                $table->integer('parent_id')->default(0)->comment('推荐人id');
            });
        }

        if (Schema::hasColumn('order', 'order_type')) {
            // Schema::table('order', function ($table) {
            //     $table->tinyInteger('order_type')->default(1)
            //     // ->comment('1预约状态(等待接受)2拒绝3流单4正执行5完成6申诉')
            //     ->change();
    
            // });
        }
        // if (Schema::hasColumn('order', 'order_type')) {
        //     Schema::table('order', function ($table) {
        //         $table->tinyInteger('order_type')->unsigned()->comment('订单状态1预约状态(等待接受)2拒绝3流单4正执行5完成6申诉')->change();
    
        //     });
        // }
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
