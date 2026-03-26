<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::create('materiels', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['Disponible', 'Sorti', 'En panne', 'Maintenance'])->default('Disponible');
            $table->date('date_maintenance')->nullable();

            $table->foreignId('sous_famille_id')->constrained();
            $table->foreignId('unite_id')->constrained(); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(){
        Schema::dropIfExists('materiels');
    }
};