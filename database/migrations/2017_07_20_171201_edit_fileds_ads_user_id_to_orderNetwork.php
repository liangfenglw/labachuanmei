<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFiledsAdsUserIdToOrderNetwork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('order_network', 'ads_user_id')) {
            Schema::table('order_network', function (Blueprint $table) {
                $table->Integer('ads_user_id')->index()->default(0)->comment('广告主id');
                $table->decimal('commission',10,2)->default(0)->comment('提成金额');
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
