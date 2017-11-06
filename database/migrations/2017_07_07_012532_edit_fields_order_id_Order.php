<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFieldsOrderIdOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('order', 'order_id')) {
            //
            Schema::table('order', function ($table) {
                $table->renameColumn('order_id', 'order_sn');
            });
            Schema::table('order_network', function ($table) {
                $table->renameColumn('order_id', 'order_sn');
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
