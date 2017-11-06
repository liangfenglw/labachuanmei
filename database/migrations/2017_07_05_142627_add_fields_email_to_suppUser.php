<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsEmailToSuppUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('supp_users', 'mobile')) {
            Schema::table('supp_users', function ($table) {
                $table->integer('mobile')->default(0)->comment('安全认证手机号');
            });
        }
        if (!Schema::hasColumn('supp_users', 'security_status')) {
            //
            Schema::table('supp_users', function ($table) {
                $table->tinyInteger('security_status')->default(0)->comment('是否设置密保,1已设置,0未设置');
            });

        }
        if (!Schema::hasColumn('supp_users', 'certificate_status')) {
            //
            Schema::table('supp_users', function ($table) {
                $table->tinyInteger('certificate_status')->default(0)->comment('是否设置证书,1已设置,0未设置');
            });
        }
        if (!Schema::hasColumn('supp_users', 'certificate_status')) {
            //
            Schema::table('supp_users', function ($table) {
                $table->tinyInteger('certificate_status')->default(0)->comment('是否设置证书,1已设置,0未设置');
            });
        }
        if (!Schema::hasColumn('supp_users', 'pw_status')) {
            //
            Schema::table('supp_users', function ($table) {
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
