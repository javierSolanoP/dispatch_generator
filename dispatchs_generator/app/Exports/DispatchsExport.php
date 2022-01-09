<?php

namespace App\Exports;

use App\Models\Dispatchs;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class DispatchsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('dispatchs')

                    ->join('vehicle_classes', 'vehicle_classes.id_vehicle_class', '=', 'dispatchs.vehicle_class_id')

                    ->join('enterprises', 'enterprises.id_enterprise', '=', 'dispatchs.enterprise_id')

                    ->join('municipalities as origin_municipality', 'origin_municipality.id_municipality', '=', 'dispatchs.origin_municipality_id')

                    ->join('departments as origin_department', 'origin_department.id_department', '=', 'origin_municipality.department_id')

                    ->join('municipalities as destination_municipality', 'destination_municipality.id_municipality', '=', 'dispatchs.destination_municipality_id')

                    ->join('departments as destination_department', 'destination_department.id_department', '=', 'destination_municipality.department_id')

                    ->select(
                        'dispatchs.invoice_number as num_fact',
                        'dispatchs.name_route as nom_ruta',
                        'dispatchs.date as fecha',
                        'dispatchs.hour as hora',
                        'dispatchs.minute as minuto',
                        'origin_department.code as d_salida',
                        'origin_municipality.code as m_salida',
                        'destination_department.code as d_llegada',
                        'destination_municipality.code as m_llegada',
                        'dispatchs.authorized_dispatch as disp_autorizado',
                        'dispatchs.type_of_dispatch as t_despacho',
                        'dispatchs.usage_rate as tasa_uso',
                        'dispatchs.plate as placa',
                        'vehicle_classes.class as clase_vehiculo',
                        'vehicle_classes.name as clase',
                        'vehicle_classes.number_of_passengers as pasajeros',
                        'enterprises.NIT',
                        'enterprises.name as nom_empre'
                    )
                    ->get();
    }
}
