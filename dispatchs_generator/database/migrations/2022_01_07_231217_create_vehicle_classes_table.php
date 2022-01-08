<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVehicleClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_classes', function (Blueprint $table) {
            $table->id('id_vehicle_class');
            $table->string('class');
            $table->string('number_of_passengers');
            $table->timestamps();
        });

        DB::insert('insert into vehicle_classes (class, number_of_passengers) values (?, ?)', ['1', '2']);
        DB::insert('insert into vehicle_classes (class, number_of_passengers) values (?, ?)', ['2', '9']);
        DB::insert('insert into vehicle_classes (class, number_of_passengers) values (?, ?)', ['3', '9']);
        DB::insert('insert into vehicle_classes (class, number_of_passengers) values (?, ?)', ['5', '6']);
        DB::insert('insert into vehicle_classes (class, number_of_passengers) values (?, ?)', ['7', '9']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_classes');
    }
}
