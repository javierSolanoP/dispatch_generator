<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEnterprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id('id_enterprise');
            $table->string('NIT');
            $table->string('name');
            $table->timestamps();
        });

        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891100279', 'COOPERATIVA DE MOTORISTAS DEL HUILA Y CAQUETA LTDA']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891101282', 'COOPERATIVA LA BOYANA DE TRANSPORTADORES LTDA']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['813002248', 'TRANSPORTE EXPRESO LA GAITANA S.A.']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891100299', 'COOPERATIVA DE TRANPORTADORES DEL HUILA LTDA COOTR']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['890700189', 'COOPERATIVA DE TRANSPORTES VELOTAX LTDA']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['890700476', 'RAPIDO TOLIMA S.A.']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891200645', 'TRANSPORTADORES DE IPIALES S.A']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891200280', 'COOPERATIVA INTEGRAL DE TRANSPORTADORES DE NARIÑO']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891200287', 'COOPERATIVA ESPECIALIZADA SUPERTAXIS DEL SUR LTDA']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['890301296', 'SULTANA DEL VALLE S.A.']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891201796', 'COOTRANSMAYO LTDA']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['890302849', 'TRANSPORTES EXPRESO PALMIRA S.A']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['890306987', 'TRANSPORTES PUERTO TEJADA LTDA']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['860005108', 'EXPRESO BOLIVARIANO S.A EN RESTRUCTURACION']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['860004838', 'FLOTA MAGDALENA S.A']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['800227937', 'CONTINENTAL BUS']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891500045', 'COOPERATIVA DE MOTORISTAS DEL CAUCA COOMOTORISTAS']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891500551', 'SOCIEDAD TRANSPORTADORA DEL CAUCA S.A SOTRACAUCA']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891500593', 'COOPERATIVA TRANSPORTADORA DE TIMBIO TRANSTIMBIO']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891500194', 'COOPERATIVA INTEGRAL DE TRANSPORTES RAPIDO TAMBO']);
        DB::insert('insert into enterprises (NIT, name) values (?, ?)', ['891500277', 'COOPERATIVA INTEGRAL DE TAXIS BELALCAZAR']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprises');
    }
}
