<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFieldsTypeNameToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function ($table) {
            $table->string('type_name',200)->default(0)->nullable()->change();
        });
        Schema::table('order_network', function ($table) {
            $table->string('type_name',200)->default(0)->nullable()->change();
        });
        Schema::table('order_network', function ($table) {
            $table->string('order_id', 30)->index()->comment('主订单id')->change();
        });
        
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
