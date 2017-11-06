<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelOrderFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('order', 'doc_type')) {
            Schema::table('order', function (Blueprint $table) {
                $table->tinyInteger('doc_type')->nullable()->comment("1外部链接2上传文档3内部编辑");
                $table->text("content")->nullable()->comment('文档内容');
                $table->string("keywords",200)->nullable()->comment('关键词');
                $table->text("remark")->nullable()->comment('备注');
            });
        }
        if (Schema::hasColumn('order_network', 'doc_type')) {
            Schema::table('order_network', function (Blueprint $table) {
                $table->dropColumn('doc_type');
                $table->dropColumn("content");
                $table->dropColumn("keywords");
                $table->dropColumn("remark");
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
