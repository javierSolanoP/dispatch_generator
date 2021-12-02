<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id('id_permission');
            $table->string('permission_type', 45)->unique()->index();
            $table->timestamps();
        });

        DB::insert('insert into permissions (permission_type) values (?)', ['crear']);
        DB::insert('insert into permissions (permission_type) values (?)', ['leer']);
        DB::insert('insert into permissions (permission_type) values (?)', ['actualizar']);
        DB::insert('insert into permissions (permission_type) values (?)', ['eliminar']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
