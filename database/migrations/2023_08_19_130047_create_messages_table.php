<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Clé étrangère pour l'utilisateur
            $table->unsignedBigInteger('from'); // Clé étrangère pour l'expéditeur
            $table->unsignedBigInteger('to'); // Clé étrangère pour le destinataire 
            $table->text('content');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('from')->references('id')->on('users');
            $table->foreign('to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
