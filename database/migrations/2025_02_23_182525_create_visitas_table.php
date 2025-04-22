<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_region')->constrained('regiaos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_objective')->constrained('objetivos')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('code_conv')->nullable();
            $table->string('enterprise');
            $table->string('cnpj');
            $table->string('activity_branch');
            $table->string('responsable');
            $table->string('company_phone');
            $table->string('city');
            $table->string('location')->nullable();
            $table->string('observation')->nullable();
            $table->string('manager_signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};
