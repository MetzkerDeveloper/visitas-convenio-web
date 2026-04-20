<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('convenios_promotors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_promotor')->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('cd_conv');
            $table->string('cnpj_conv');
            $table->string('nm_conv');
            $table->string('reg_conv');
            $table->string('end_conv');
            $table->string('cidade_conv');
            $table->boolean('status_visita')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenios_promotors');
    }
};
