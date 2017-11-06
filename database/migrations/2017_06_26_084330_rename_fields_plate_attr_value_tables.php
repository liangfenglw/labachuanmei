<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFieldsPlateAttrValueTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
  

        if (Schema::hasColumn('plate_attr_value', 'plate_id')) {
            //
            Schema::table('plate_attr_value', function ($table) {
                // $table->string('plate_id');
                // $table->renameColumn('plate_id', 'attr_id');

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
