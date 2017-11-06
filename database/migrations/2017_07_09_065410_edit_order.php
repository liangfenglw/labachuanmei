<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('order', 'cooperation_mode')) {
            Schema::table('order', function (Blueprint $table) {

                // $table->integer('parent_id')->default(0)->comment('推荐人id');
                $table->string('cooperation_mode')->nullable()->comment('合作方式(目前针对视频营销)');
                $table->string('cooperation_place')->nullable()->comment('合作地点(目前针对视频营销)');
                $table->string('sale_file')->nullable()->comment('上传附件(目前针对视频营销)');
            });
        }

        if (!Schema::hasColumn('cart', 'cooperation_mode')) {
            Schema::table('cart', function (Blueprint $table) {

                // $table->integer('parent_id')->default(0)->comment('推荐人id');
                $table->string('cooperation_mode')->nullable()->comment('合作方式(目前针对视频营销)');
                $table->string('cooperation_place')->nullable()->comment('合作地点(目前针对视频营销)');
                $table->string('sale_file')->nullable()->comment('上传附件(目前针对视频营销)');
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
