<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFieldsStatusInvoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invo', function ($table) {
            $table->dropColumn(['status']);
        });
        if (Schema::hasTable('invo')) {
            Schema::table('invo', function ($table) {
                $table->tinyInteger('status')->default(1)->comment('提现状态1未完成2已完成');
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
