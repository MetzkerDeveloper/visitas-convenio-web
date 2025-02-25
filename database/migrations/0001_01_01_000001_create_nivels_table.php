<?php

use App\Models\Nivel;
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
        Schema::create('nivels', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->timestamps();
        });

        $niveis = [
            1 => 'ADMINISTRADOR',
            2 => 'GERENTE',
            3 => 'PROMOTOR',
        ];

        foreach ($niveis as $value) {
            Nivel::query()->create([
                'descricao' => $value,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nivels');
    }
};
