<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SecurityQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('security_question')) {
            Schema::create('security_question', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('cat_id')->comment('分类id');
                $table->string('name')->comment('问题');
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
