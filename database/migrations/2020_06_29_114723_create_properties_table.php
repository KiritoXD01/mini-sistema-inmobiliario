<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->unique();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('price');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('property_status_id');
            $table->unsignedBigInteger('property_type_id');
            $table->unsignedBigInteger('property_legal_condition_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id')->default(0);
            $table->unsignedBigInteger('created_by')->default(0);
            $table->timestamps();

            $table->foreign("property_status_id")->references("id")->on("property_status");
            $table->foreign('property_type_id')->references('id')->on("property_types");
            $table->foreign('property_legal_condition_id')->references('id')->on('property_legal_conditions');
            $table->foreign("country_id")->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
