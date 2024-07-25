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
            $table->text('texto');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('noticia_id'); // Añadir el campo noticia_id
            $table->timestamps();

            // Claves foráneas
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('noticia_id')
                ->references('id')->on('noticias')
                ->onUpdate('cascade')->onDelete('restrict');
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
            $table->dropForeign('comentarios_user_id_foreign');
            $table->dropForeign('comentarios_noticia_id_foreign'); // Añadir esta línea para borrar la clave foránea
        });
        Schema::dropIfExists('comentarios');
    }
}
