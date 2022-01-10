<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMunicipalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipalities', function (Blueprint $table) {
            $table->id('id_municipality');
            $table->string('code');
            $table->string('name');
            $table->boolean('main');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id_department')->on('departments');
            $table->timestamps();

        });

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19001000', 'POPAYAN', '1', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19022000', 'ALMAGUER', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19050000', 'ARGELIA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19100000', 'BOLIVAR', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19517000', 'BELALCAZAR', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19075000', 'BALBOA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19142011', 'CALOTO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19130000', 'CAJIBIO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19137000', 'CALDONO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19585000', 'COCONUCO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19693001', 'EL ROSAL', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19290000', 'FLORENCIA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19100013', 'GUACHICONO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19355000', 'INZA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19364000', 'JAMBALO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19701000', 'LOS CORTES', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19397000', 'LA VEGA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19450000', 'MERCADERES', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19473000', 'MORALES', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19050006', 'EL PLATEADO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19585009', 'PALETARA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19760000', 'PAISPAMBA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19548000', 'PIENDAMO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19573000', 'PUERTO TEJADA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19622000', 'ROSAS', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19785000', 'SUCRE', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19318012', 'SAN AGUSTIN', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19050007', 'SINAI ARGELIA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19780000', 'SUAREZ', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19392000', 'LA SIERRA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19698000', 'S QUILICHAO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19743000', 'SILVIA', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19693004', 'SANTIAGO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19100021', 'SAN LORENZO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19256000', 'EL TAMBO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19807000', 'TIMBIO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19824000', 'TOTORO', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19100005', 'CARMEN BOLIVAR', '0', '1']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['19532000', 'EL BORDO', '0', '1']);

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['76001000', 'CALI', '1', '2']);

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['52001000', 'PASTO', '1', '3']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['52378000', 'LA CRUZ', '0', '3']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['52835000', 'TUMACO', '0', '3']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['52399000', 'LA UNION', '0', '3']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['52356000', 'IPIALES', '0', '3']);

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['86001000', 'MOCOA', '1', '4']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['86568000', 'PUERTO ASIS', '0', '4']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['86757000', 'SAN MIGUEL', '0', '4']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['86320000', 'ORITO', '0', '4']);

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['41001000', 'NEIVA', '1', '5']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['41551000', 'PITALITO', '0', '5']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['41396000', 'LA PLATA', '0', '5']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['41668000', 'SAN MIGUEL', '0', '5']);

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['63001000', 'ARMENIA', '1', '6']);

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['66001000', 'PEREIRA', '1', '7']);

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['18001000', 'FLORENCIA', '1', '8']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['18753000', 'SAN VICENTE', '0', '8']);
        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['18592000', 'PUERTO RICO', '0', '8']);

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['05001000', 'MEDELLIN', '1', '9']);

        DB::insert('insert into municipalities (code, name, main, department_id) values (?, ?, ?, ?)', ['11001000', 'BOGOTA', '1', '10']);

        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipalities');
    }
}
