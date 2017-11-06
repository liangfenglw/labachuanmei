<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //角色表
        if (!Schema::hasTable('admin_role')) {
            Schema::create('admin_role', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('level_name',100)->comment('等级');
                $table->string('remark',100)->nullable()->comment('备注');
                $table->comment = '权限表';
                $table->timestamps();//创建时间、更新时间
                $table->softDeletes();//软删除
            });
        }
        //菜单、权限栏
        if (!Schema::hasTable('admin_menu')) {
            Schema::create('admin_menu', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->Integer('pid')->comment('上级id');
                $table->tinyInteger('level_id')->default(1)->comment('菜单级数');
                $table->tinyInteger('type')->default(2)->comment('1菜单,2栏目下的方法');
                $table->tinyInteger('is_show')->default(1)->comment('1显示2隐藏');
                $table->string('menu',100)->comment('栏目名、方法名');
                $table->string('ico',255)->nullable()->comment('栏目图标');
                $table->string('route',255)->nullable()->comment('路由');
                $table->comment = '菜单栏';
                $table->timestamps();//创建时间、更新时间
                $table->softDeletes();//软删除
            });
        }
        //拥有的权限
        if (!Schema::hasTable('admin_vs_role')) {
            Schema::create('admin_vs_role', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->Integer('uid')->comment('管理员id');
                $table->Integer('menu_id')->comment('菜单id');
                $table->comment = '用户拥有的权限';
                $table->timestamps();//创建时间、更新时间
                $table->softDeletes();//软删除
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
