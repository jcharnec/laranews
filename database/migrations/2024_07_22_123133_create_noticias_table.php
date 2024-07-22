<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();

            $table->string('titulo', 255);
            $table->string('tema', 255);
            $table->text('texto'); // Ajustado para ser tipo text
            $table->string('imagen', 255)->nullable();
            $table->integer('visitas')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            // Marcas de tiempo: campos created_at y updated_at
            $table->timestamps();
            // Marca de tiempo de borrado
            $table->softDeletes();
            // Campo published_at
            $table->timestamp('published_at')->nullable();
            // Campo rejected
            $table->boolean('rejected')->default(false);
            // Relaciona los dos campos
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::table('noticias', function (Blueprint $table) {
            $table->dropForeign('noticias_user_id_foreign');
        });
        Schema::dropIfExists('noticias');
    }
}
