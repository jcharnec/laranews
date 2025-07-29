<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();

            $table->string('titulo', 255);
            $table->string('tema', 255);
            $table->text('texto');
            $table->string('imagen', 255)->nullable();
            $table->integer('visitas');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('noticia_id'); // ← Añadido

            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('published_at')->nullable();
            $table->boolean('rejected')->default(false);

            // Claves foráneas
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('noticia_id') // ← Añadido
                ->references('id')->on('noticias')
                ->onDelete('cascade'); // Eliminación en cascada
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['noticia_id']); // ← Añadido
        });

        Schema::dropIfExists('comentarios');
    }
}
