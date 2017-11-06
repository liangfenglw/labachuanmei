<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAccountLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('user_account_log', 'status')) {
            //
            Schema::table('user_account_log', function ($table) {
                $table->tinyInteger('status')->default(0)->comment('状态，1已到账,0未到账(等待),2失败(目前针对充值,提现)');
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
