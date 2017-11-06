<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersHeadPic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasColumn('users', 'head_pic')) {
            //
            Schema::table('users', function ($table) {
                $table->string('head_pic');
            });

        }

        if (Schema::hasColumn('ad_users', 'head_pic')) {
            //
            Schema::table('ad_users', function ($table) {
                 $table->dropColumn('head_pic');
            });

        }

        if (Schema::hasColumn('users', 'email')) {
            //
            Schema::table('users', function ($table) {
                 $table->dropColumn('email');
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
