<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoomQuantityColumnToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->smallInteger('bedroom_quantity');
            $table->smallInteger("bathroom_quantity");
            $table->smallInteger('lounge_quantity');
            $table->integer('parking_quantity');
            $table->smallInteger('kitchen_quantity');
            $table->integer("property_level");
            $table->boolean('has_water')->default(0);
            $table->boolean('has_heating')->default(0);
            $table->boolean('has_air_conditioning')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->removeColumn("bedroom_quantity");
            $table->removeColumn("bathroom_quantity");
            $table->removeColumn("lounge_quantity");
            $table->removeColumn("parking_quantity");
            $table->removeColumn("kitchen_quantity");
            $table->removeColumn("property_level");
            $table->removeColumn("has_water");
            $table->removeColumn("has_heating");
            $table->removeColumn("has_air_conditioning");
        });
    }
}
