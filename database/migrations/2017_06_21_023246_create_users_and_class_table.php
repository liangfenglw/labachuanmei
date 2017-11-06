<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAndClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建分类表
        if (!Schema::hasTable('plate')) {
            Schema::create('plate', function (Blueprint $table) {
                $table->increments('id');
                $table->string('plate_name',120)->comment('板块名');
                $table->integer('pid')->default(0)->comment('上级id');
                $table->string('path',120)->default(0)->comment('上级id_本级id');
                $table->timestamps();
            });
        }
        // 属性表
        if (!Schema::hasTable('plate_attr')) {
            Schema::create('plate_attr', function (Blueprint $table) {
                $table->increments('id');
                $table->string('attr_name',120)->comment('属性名');
                $table->integer('plate_id')->default(0)->comment('板块id');
                $table->string('path',120)->default(0)->comment('顶级id_二级板块id_自己的id');
                $table->timestamps();
            });
        }
        // 属性值表
        if (!Schema::hasTable('plate_attr_value')) {
            Schema::create('plate_attr_value', function (Blueprint $table) {
                $table->increments('id');
                $table->string('attr_name',120)->comment('属性名');
                $table->string('attr_value',200)->comment('属性值');
                $table->string('remark',200)->nullable()->comment('备注');
                $table->integer('plate_id')->default(0)->comment('板块id');
                $table->string('path',120)->default(0)->comment('顶级id_二级板块id_属性id_自己id');
                $table->timestamps();
            });
        }
        // 广告主用户表
        if (!Schema::hasTable('ad_users')) {
            Schema::create('ad_users', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->comment('用户id 对应users');
                $table->string('head_pic',200)->nullable()->comment('用户头像');
                $table->string('name',120)->comment('用户名');
                $table->string('nickname',120)->comment('昵称');
                $table->string('company',200)->comment('企业昵称');
                $table->text('breif')->nullable()->comment('简介');
                $table->string('contact',120)->nullable()->comment('联系人');
                $table->string('qq',30)->nullable()->comment('qq');
                $table->string('mobile',15)->nullable()->comment('手机');
                $table->string('email',80)->nullable()->comment('邮箱');
                $table->string('address',200)->nullable()->comment('地址');
                $table->timestamps();
            });
        }
        // 供应商用户表
        if (!Schema::hasTable('supp_users')) {
            Schema::create('supp_users', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->comment('用户id 对应users');
                $table->string('name')->comment('用户名');
                $table->string('belong',120)->comment('所属媒体(推荐人)');
                $table->integer('plate_tid')->comment('顶级分类id');
                $table->integer('plate_id')->comment('分类id(2级)');
                $table->string('media_name',200)->comment('媒体名称');
                $table->string('media_logo',200)->comment('媒体logo');
                $table->string('index_logo',200)->comment('入口示意图');
                $table->decimal('proxy_price',10,2)->comment('代理价');
                $table->decimal('platform_price',10,2)->comment('平台价');
                $table->string('media_contact',200)->comment('媒体负责人');
                $table->string('contact_phone',20)->comment('联系电话');
                $table->string('email',50)->comment('联系邮箱');
                $table->string('qq',30)->comment('qq');
                $table->string('address',200)->comment('联系地址');
                $table->string('zip_code',200)->nullable()->comment('邮编');
                $table->string('media_check',120)->comment('媒体认证(执照这些)');
                $table->string('media_check_file',200)->comment('认证图');
                $table->text('breif')->nullable()->comment('媒体简介');
                $table->text('remark')->nullable()->comment('备注');
                $table->tinyInteger('is_state')->comment('状态1在线2下架3审核');
                $table->timestamps();
            });
        }

        // 供应商属性值对应关系
        if (!Schema::hasTable('supp_vs_attr')) {
            Schema::create('supp_vs_attr', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->comment('用户id 对应users');
                $table->integer('attr_value_id')->comment('属性值表的id');
                $table->comment = '供应商属性值对应关系';
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
