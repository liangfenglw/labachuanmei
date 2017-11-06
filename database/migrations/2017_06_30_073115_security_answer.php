<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SecurityAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('security_answer')) {
            Schema::create('security_answer', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id')->comment('用户id');
                $table->integer('question_id')->comment('问题id');
                $table->string('name')->comment('答案');
                $table->tinyInteger('is_show')->default(1)->comment('是否显示,1显示,0隐藏,冗余字段');
                $table->tinyInteger('sort')->default(100)->comment('排序,冗余字段');
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('ad_users', 'security_status')) {
            //
            Schema::table('ad_users', function ($table) {
                $table->tinyInteger('security_status')->default(0)->comment('是否设置密保,1已设置,0未设置');
            });

        }

        if (!Schema::hasColumn('ad_users', 'certificate_status')) {
            //
            Schema::table('ad_users', function ($table) {
                $table->tinyInteger('certificate_status')->default(0)->comment('是否设置证书,1已设置,0未设置');
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
