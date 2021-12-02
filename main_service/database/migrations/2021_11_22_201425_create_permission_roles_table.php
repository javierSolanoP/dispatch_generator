<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_roles', function (Blueprint $table) {
            $table->id('id_permission_role');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->foreign('role_id')->references('id_role')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id_permission')->on('permissions')->onDelete('cascade');
            $table->timestamps();
        });

        DB::insert('insert into permission_roles (role_id, permission_id) values (?, ?)', ['1', '1']);
        DB::insert('insert into permission_roles (role_id, permission_id) values (?, ?)', ['1', '2']);
        DB::insert('insert into permission_roles (role_id, permission_id) values (?, ?)', ['1', '3']);
        DB::insert('insert into permission_roles (role_id, permission_id) values (?, ?)', ['1', '4']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_roles');
    }
}
