<?php

use Illuminate\support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建用户表
        if (!Schema::hasTable('customer')) {
            Schema::create('customer', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('realname',80)->comment('昵称');
                $table->string('username',80)->nullable()->comment('真实姓名');
                $table->string('mobile',15)->nullable()->index()->comment('手机号');
                $table->string('password',150)->comment('密码');
                $table->tinyInteger('is_vip')->index()->default(2)->comment('1会员2普通会员');
                $table->tinyInteger('is_check')->index()->default(2)->comment('1已认证2待认证3等待验证中');
                $table->string('headimg',255)->default(2)->comment('头像');
                $table->tinyInteger('sex')->default(0)->comment('性别1男2女0未知');
                $table->comment = '用户表';
                $table->timestamps();//创建时间、更新时间
                $table->softDeletes();//软删除
            });
        }

        //创建微信用户表
        if (!Schema::hasTable('weixin')) {
            Schema::create('weixin', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->integer('cid')->unsigned()->index()->comment('用户id');
                $table->string('wechat_name',80)->nullable()->comment('微信名字');
                $table->string('heading',200)->nullable()->comment('微信头像');
                $table->string('openid',200)->index()->comment('微信openid');
                $table->comment = '微信表';
                $table->timestamps();//创建时间、更新时间
                $table->softDeletes();//软删除
            });
        }
        // //创建个人认证资料表
        if (!Schema::hasTable('customer_check')) {
            Schema::create('customer_check', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->integer('cid')->index()->unsigned()->comment('用户id');
                $table->integer('mobile')->index()->unsigned()->comment('手机号');
                $table->tinyInteger('sex')->default(0)->comment('性别0未知1男2女');
                $table->string('image',200)->nullable()->comment('住的照片');
                $table->tinyInteger('is_check')->default(0)->comment('是否审核1提交审核2审核中3审核成功4审核不通过');
                $table->comment = '用户认证资料表';
                $table->timestamps();//创建时间、更新时间
                $table->softDeletes();//软删除
            });
        }
        //创建用户关注的人
        if (!Schema::hasTable('attenion')) {
            Schema::create('attenion', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->integer('cid')->index()->unsigned()->comment('用户id');
                $table->integer('mobile')->index()->unsigned()->comment('手机号');
                $table->tinyInteger('sex')->comment('性别');
                $table->string('image',200)->comment('住的照片');
                $table->tinyInteger('is_check')->comment('是否审核1提交审核2审核中3审核成功4审核不通过');
                $table->comment = '用户互相关注表';
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
