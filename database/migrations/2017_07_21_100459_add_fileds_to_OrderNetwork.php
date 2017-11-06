<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledsToOrderNetwork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('order_network', 'platform')) {
            Schema::table('order_network', function (Blueprint $table) {
                $table->decimal('platform',10,2)->default(0)->comment('平台所得');
                $table->decimal('supp_money',10,2)->default(0)->comment('供应商所得');
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
