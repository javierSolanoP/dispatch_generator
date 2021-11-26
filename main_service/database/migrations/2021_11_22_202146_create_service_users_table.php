<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateServiceUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_users', function (Blueprint $table) {
            $table->id('id_service_user');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id_service')->on('services')->onDelete('cascade');
            $table->timestamps();
        });

        DB::insert('insert into service_users (user_id, service_id) values (?, ?)', [1, 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_users');
    }
}
