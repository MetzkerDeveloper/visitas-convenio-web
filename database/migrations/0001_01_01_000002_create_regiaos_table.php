<?php

use App\Models\Regiao;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('regiaos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $regioes = [
            1  => 'TO',
            2  => 'GV',
            3  => 'DIA',
            4  => 'ES',
            5  => 'BA',
            6  => 'BA2',
            7  => 'VA',
            8  => 'VA2',
            9  => 'VJ',
            10 => 'PS',
            11 => 'OP',
            12 => 'ZM',
        ];

        foreach ($regioes as $value) {

            Regiao::query()->create([
                'name' => $value,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regiaos');
    }
};
