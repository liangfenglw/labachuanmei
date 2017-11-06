<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsReadLogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('news_read_log')) {
            Schema::create('news_read_log', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->index()->comment('用户id');
                $table->integer('article_id')->index()->comment('文章id');
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
