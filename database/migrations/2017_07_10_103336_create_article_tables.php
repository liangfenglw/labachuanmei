<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('category')) {
            Schema::create('category', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pid')->default(0)->comment('上级栏目');
                $table->integer('category_name')->comment('栏目名');
                $table->integer('sortorder')->default(99)->comment("排序大到小");
                $table->tinyInteger('status')->default(1)->comment('1在线2下架');
                $table->integer('type_id')->nullable()->comment();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('article')) {
            Schema::create('article', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id')->default(0)->comment('栏目id');
                $table->string('article_name',200)->comment('文章名');
                $table->integer('origin')->default(99)->comment("来源");
                $table->text('content')->comment("文章内容");
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
