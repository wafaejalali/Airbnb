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
            $table->unsignedBigInteger('user_id'); // Clé étrangère
            $table->string('title');
            $table->text('description');
            $table->string('type');
            $table->decimal('daily_rate', 10, 2);
            $table->text('equipments')->nullable();
            $table->string('picture')->nullable();
            $table->unsignedBigInteger('res_id')->nullable(); // Clé étrangère
            $table->unsignedBigInteger('notice_id')->nullable(); // Clé étrangère
            $table->unsignedBigInteger('disp_id')->nullable(); // Clé étrangère
            $table->timestamps();

            // Clés étrangères
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('res_id')->references('id')->on('res');
            $table->foreign('notice_id')->references('id')->on('notices');
            $table->foreign('disp_id')->references('id')->on('disponibility');
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
