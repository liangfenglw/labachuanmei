<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AduserEdit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        if (!Schema::hasColumn('ad_users', 'pw_status')) {
            //
            Schema::table('ad_users', function ($table) {
                $table->tinyInteger('pw_status')->default(1)->comment('是否设置密码,冗余');
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
