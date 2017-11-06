<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAdUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_users', function ($table) {
            $table->string('nickname',120)->nullable()->change();
            $table->string('company',200)->nullable()->change();
            $table->text('breif')->nullable()->change();
            $table->string('contact',120)->nullable()->change();
            $table->string('qq',30)->nullable()->change();
            $table->string('mobile',15)->nullable()->change();
            $table->string('email',80)->nullable()->change();
            $table->string('address',200)->nullable()->change();
        });

        Schema::table('users', function ($table) {
            $table->string('head_pic')->nullable()->change();
        });
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
