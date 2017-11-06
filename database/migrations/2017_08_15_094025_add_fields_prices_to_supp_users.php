<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsPricesToSuppUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('supp_users', 'vip_price')) {
            Schema::table('supp_users', function (Blueprint $table) {
                $table->decimal('vip_price',10,2)->default(0)->comment('vip价格');
                $table->decimal('plate_price',10,2)->default(0)->comment('平台价格');
                $table->Integer('vip_rate')->default(100)->comment('会员价比率');
                $table->Integer('plate_rate')->default(100)->comment('平台价比率');
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
