<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditMobileSuppUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('supp_users', 'mobile')) {
            Schema::table('supp_users', function (Blueprint $table) {
                $table->dropColumn('mobile');
            });
        }
        if (!Schema::hasColumn('supp_users', 'mobile')) {
            Schema::table('supp_users', function (Blueprint $table) {
                $table->bigInteger('mobile')->nullable()->default(0)->comment('密保手机号');
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
