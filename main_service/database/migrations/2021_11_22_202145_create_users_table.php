<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('identification', 10)->unique()->index();
            $table->string('name', 100);
            $table->string('last_name', 100);
            $table->string('email');
            $table->string('user_name', 50)->unique()->index();
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id_role')->on('roles');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            DB::insert('insert into users (identification, name, last_name, email, user_name, password, role_id) values (?, ?, ?, ?, ?, ?, ?)', ['0123456879', 'Admin', 'TIC', 'tic@terminalpopayan.com', 'root', '$2y$10$JrHmRIxd8Uzjfq5xchNZu.xbs1ChvRLSwfgP5Ttm.7liQl4RJ2t7u', 1]);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
