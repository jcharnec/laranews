<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->string('tema', 255);
            $table->text('texto');
            $table->string('imagen', 255)->nullable();
            $table->integer('visitas')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('rejected')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('noticias');
    }
}
