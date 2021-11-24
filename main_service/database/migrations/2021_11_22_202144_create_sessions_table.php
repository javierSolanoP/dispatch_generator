<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id('id_session');
            $table->string('type_of_session');
            $table->timestamps();
        });

        Schema::table('sessions', function (Blueprint $table) {
            DB::insert('insert into sessions (type_of_session) values (?)', ['Activa']);
            DB::insert('insert into sessions (type_of_session) values (?)', ['Inactiva']);
            DB::insert('insert into sessions (type_of_session) values (?)', ['Pendiente']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
