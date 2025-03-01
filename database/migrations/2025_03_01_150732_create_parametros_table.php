<?php

use App\Models\Parametro;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parametros', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        $parametros[] = [
            'name' => 'COMISSAO VISITAS',
            'value' => '2',
            'description' => 'Valor da comissão por visita',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $parametros[] = [
            'name' => 'BLOQUEIO VISITA',
            'value' => '5',
            'description' => 'Bloqueio visita fora do período',
            'created_at' => now(),
            'updated_at' => now(),
        ];

       Parametro::insert($parametros);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros');
    }
};
