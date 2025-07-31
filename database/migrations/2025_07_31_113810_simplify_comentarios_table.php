<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            // Eliminar columnas innecesarias
            $table->dropColumn([
                'titulo',
                'tema',
                'imagen',
                'visitas',
                'deleted_at',
                'published_at',
                'rejected'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->string('titulo', 255)->nullable();
            $table->string('tema', 255)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->integer('visitas')->default(0);
            $table->softDeletes();
            $table->timestamp('published_at')->nullable();
            $table->boolean('rejected')->default(false);
        });
    }
};
