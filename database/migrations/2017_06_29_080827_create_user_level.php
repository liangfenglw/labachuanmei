<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_level')) {
            Schema::create('user_level', function (Blueprint $table) {
                $table->increments('id');
                $table->string('level_name',30)->comment('头衔名称');
                $table->decimal('amount',15,2)->comment('等级必要金额');
                $table->string('describe')->comment('头街 描述');
                $table->timestamps();
            });
        }
        //
        if (!Schema::hasColumn('ad_users', 'level_id')) {
            //
            Schema::table('ad_users', function ($table) {
                $table->string('level_id')->default(1)->comment('头街等级');
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
