<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'population')) {
                $table->string('population', 255)->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code', 10)->nullable()->after('population');
            }
            if (!Schema::hasColumn('users', 'birthdate')) {
                $table->date('birthdate')->nullable()->after('postal_code');
            }
            // 'imagen' ya existe en tu CreateUsersTable
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'birthdate')) $table->dropColumn('birthdate');
            if (Schema::hasColumn('users', 'postal_code')) $table->dropColumn('postal_code');
            if (Schema::hasColumn('users', 'population')) $table->dropColumn('population');
        });
    }
}
