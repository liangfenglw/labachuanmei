<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplySuppsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('apply_supps')) {
            Schema::create('apply_supps', function (Blueprint $table) {
                $table->increments('id');
                $table->string('plate_tid', 30)->index()->comment('资源分类');
                $table->integer('plate_id')->index()->comment("资源类型");
                $table->string('name',200)->comment('资源名称');
                $table->string('meida_logo',200)->nullable()->comment('媒体logo');
                $table->string('company_name',200)->nullable()->comment('公司名');
                $table->string('address')->nullable()->comment('地址');
                $table->string('media_contact',200)->comment('媒体负责人');
                $table->string('contact_phone',20)->comment('联系电话');
                $table->string('email',50)->comment('联系邮箱');
                $table->text('breif')->nullable()->comment('媒体简介');
                $table->string('operaer',100)->nullable()->comment('操作人');
                $table->timestamps();
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
