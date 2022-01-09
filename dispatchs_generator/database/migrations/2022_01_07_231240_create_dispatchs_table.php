<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

class CreateDispatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatchs', function (Blueprint $table) {
            $table->id('id_dispatch');
            $table->string('invoice_number');
            $table->string('name_route');
            $table->string('date');
            $table->string('hour');
            $table->string('minute');
            $table->string('authorized_dispatch');
            $table->string('type_of_dispatch');
            $table->string('usage_rate');
            $table->string('plate');
            $table->unsignedBigInteger('vehicle_class_id');
            $table->unsignedBigInteger('enterprise_id');
            $table->unsignedBigInteger('origin_municipality_id');
            $table->unsignedBigInteger('destination_municipality_id');
            $table->foreign('vehicle_class_id')->references('id_vehicle_class')->on('vehicle_classes');
            $table->foreign('enterprise_id')->references('id_enterprise')->on('enterprises');
            $table->foreign('origin_municipality_id')->references('id_municipality')->on('municipalities');
            $table->foreign('destination_municipality_id')->references('id_municipality')->on('municipalities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispatchs');
    }
}
