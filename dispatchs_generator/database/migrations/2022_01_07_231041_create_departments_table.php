<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('id_department');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        DB::insert('insert into departments (code, name) values (?, ?)', ['19', 'CAUCA']);
        DB::insert('insert into departments (code, name) values (?, ?)', ['76', 'VALLE DEL CAUCA']);
        DB::insert('insert into departments (code, name) values (?, ?)', ['52', 'NARIÑO']);
        DB::insert('insert into departments (code, name) values (?, ?)', ['86', 'PUTUMAYO']);
        DB::insert('insert into departments (code, name) values (?, ?)', ['41', 'HUILA']);
        DB::insert('insert into departments (code, name) values (?, ?)', ['63', 'QUINDIO']);
        DB::insert('insert into departments (code, name) values (?, ?)', ['66', 'RISARALDA']);
        DB::insert('insert into departments (code, name) values (?, ?)', ['18', 'CAQUETA']);
        DB::insert('insert into departments (code, name) values (?, ?)', ['05', 'ANTIOQUIA']);
        DB::insert('insert into departments (code, name) values (?, ?)', ['11', 'BOGOTA']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
