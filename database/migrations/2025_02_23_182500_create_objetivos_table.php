<?php

use App\Models\Objetivo;
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
        Schema::create('objetivos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $objetivos = [
            1 => 'CAPTACAO',
            2 => 'LOJA',
            3 => 'MANUTENCAO',
        ];

        foreach ($objetivos as $value) {
            Objetivo::query()->create([
                'name' => $value,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetivos');
    }
};
