<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::create('mouvements', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'Transfert', 'Panne', 'Sortie', 'Retour'
            $table->text('commentaire')->nullable();

            // The user And What he did ( add, transfer, ... )
            $table->foreignId('materiel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained();

            // from unit to another , It can be null depends on the mouvement type
            $table->foreignId('from_unite_id')->nullable()->constrained('unites');
            $table->foreignId('to_unite_id')->nullable()->constrained('unites');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(){
        Schema::dropIfExists('mouvements');
    }
};