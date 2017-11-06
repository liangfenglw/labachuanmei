<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSuppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('supp_users', 'order_count')) {
            Schema::table('supp_users', function ($table) {
                $table->integer('order_count')->default(0)->comment('订单数');
                $table->decimal('user_money',10,2)->default(0)->comment('用户金额');
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
