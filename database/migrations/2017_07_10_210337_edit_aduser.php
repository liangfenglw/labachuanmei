<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTO_user extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('ad_users', 'parent_commision')) {
            Schema::table('ad_users', function (Blueprint $table) {
                $table->tinyInteger('mobile_status')->default(0)->comment('是否已经绑定手机');
                $table->tinyInteger('email_status')->default(0)->comment('是否已经绑定电子邮箱');
                $table->decimal('parent_commision',10,2)->default('0.00')->comment('上级获得的佣金');
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
