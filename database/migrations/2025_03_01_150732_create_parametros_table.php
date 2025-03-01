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
            $table->string('description')->nullable();
            $table->timestamps();
        });

        $parametros = [
            'name' => 'COMISSAO VISITAS',
            'value' => '2',
            'description' => 'Valor da comissão por visita',
        ];

       Parametro::create($parametros);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros');
    }
};
