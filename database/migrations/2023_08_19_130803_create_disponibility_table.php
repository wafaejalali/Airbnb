<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisponibilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disponibility', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id'); // Clé étrangère pour la propriété
            $table->date('date');
            $table->boolean('isDisponible');
            $table->timestamps();

            // Clé étrangère
            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disponibility');
    }
}
