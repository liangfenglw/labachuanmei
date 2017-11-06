<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificateCat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('certificate_cat')) {
            Schema::create('certificate_cat', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->comment('证件名称');
                $table->tinyInteger('is_show')->default(1)->comment('是否显示,1显示,0隐藏,冗余字段');
                $table->tinyInteger('sort')->default(100)->comment('排序,冗余字段');
                $table->timestamps();
                // $table->timestamp('created_at')comment('添加时间')->nullable();
            });
        }

        if (!Schema::hasTable('user_certificate_pic')) {
            Schema::create('user_certificate_pic', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id')->comment('用户id');
                $table->integer('certificate_id')->comment('证件id');
                $table->string('certificate_pic');
                $table->tinyInteger('is_show')->default(1)->comment('是否显示,1显示,0隐藏,冗余字段');
                $table->tinyInteger('sort')->default(100)->comment('排序,冗余字段');
                $table->timestamps();
                // $table->timestamp('created_at')comment('添加时间')->nullable();
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
