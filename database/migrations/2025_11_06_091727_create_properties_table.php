<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('pro_name');
            $table->string('pro_address');
            $table->string('pro_area')->nullable();
            $table->integer('pro_bed')->nullable();
            $table->integer('pro_bath')->nullable();
            $table->string('pro_img')->nullable();
            $table->foreignId('type_id')->constrained('property_types')->onDelete('cascade');
            $table->timestamps();
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
};
