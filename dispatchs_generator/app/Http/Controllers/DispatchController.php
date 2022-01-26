<?php

namespace App\Http\Controllers;

use App\Exports\DispatchsExport;
use App\Imports\DispatchController as ImportsDispatchController;
use App\Models\Dispatchs;
use App\Models\Enterprises;
use App\Models\Municipalities;
use App\Models\VehicleClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DispatchController extends Controller
{
    public function import(Request $request){

        Dispatchs::getQuery()->delete();
        
        $request->file('dispatch')->storeAs('public', $request->file('dispatch')->getClientOriginalName());
       
        $collection = Excel::toCollection(new ImportsDispatchController, 'public/'.$request->file('dispatch')->getClientOriginalName());

        $modelMunicipality = DB::table('municipalities')

                    ->join('departments', 'departments.id_department', '=', 'municipalities.department_id')

                    ->select('municipalities.id_municipality as id', 'municipalities.name as municipality', 'departments.code as department_code', 'municipalities.code as municipality_code', 'municipalities.main')
                    
                    ->get();

        $modelVehicleClass = VehicleClass::select('id_vehicle_class as id', 'name', 'class', 'number_of_passengers')->get();
        
        $modelEnterprise = Enterprises::select('id_enterprise as id', 'NIT', 'name')->get();
        
        foreach($collection as $matrix){

            foreach($matrix as $array){

                $rate = 0;
                $alcoholimetry = 0;

                for($i = 0; $i < count($array); $i ++){

                    if($i == 1){

                        $main = [];

                        foreach($modelMunicipality as $content){

                            if(strstr($array[$i], "$content->municipality -") && !strstr($array[$i], "- $content->municipality -")){
                                    
                                $main['origin'] = $content->main;
                                $array[5] = $content->department_code;
                                $array[6] = $content->municipality_code;
                                $array['origin_municipality_id'] = $content->id; 
                            }

                            if(strstr($array[$i], "- $content->municipality") && !strstr($array[$i], "- $content->municipality -")){
                                
                                $main['destination'] = $content->main;
                                $array[7] = $content->department_code;
                                $array[8] = $content->municipality_code;
                                $array['destination_municipality_id'] = $content->id;
                            }
                            
                            if(strstr($array[$i], "TRANSITO")){

                                if(!strstr($array[$i], "- BOGOTA") && !strstr($array[$i], "- CALI")){

                                    $main['origin'] = 1;
                                    $array[5] = 76;
                                    $array[6] = 76001000;
                                    $array['origin_municipality_id'] = 40; 

                                    if(strstr($array[$i], "- $content->municipality")){

                                        $array[$i] = "CALI - POPAYAN - $content->municipality";

                                        $main['destination'] = $content->main;
                                        $array[7] = $content->department_code;
                                        $array[8] = $content->municipality_code;
                                        $array['destination_municipality_id'] = $content->id;

                                    }
                                }
                            }

                            if(strstr($array[$i], "- $content->municipality -")){
                                $main['transition'] = $content->main;
                            }

                            if(isset($main['origin']) && !isset($main['transition']) && isset($main['destination'])){

                                $array[10] = 1;

                                if($main['origin'] && $main['destination']){
                                    $array[9] = 2;
                                }elseif(!$main['destination']){
                                    $array[9] = 1;
                                }

                            }elseif(isset($main['origin']) && isset($main['transition']) && isset($main['destination'])){

                                $array[10] = 2;

                                if($main['origin'] && $main['transition'] && $main['destination']){
                                    $array[9] = 3;
                                }elseif(!$main['origin'] && $main['transition'] && $main['destination']){
                                    $array[9] = 4;
                                }elseif($main['origin'] && $main['transition'] && !$main['destination']){
                                    $array[9] = 5;
                                }

                            }

                        }    
        
                    }

                    if($i == 11){
                        $rate = $array[$i];
                    }elseif($i == 13){
                        $alcoholimetry = $array[$i];
                    }

                    $array[14] = $rate + $alcoholimetry;

                    if($i == 17){
                        
                        foreach($modelVehicleClass as $vehicle){

                            if($array[$i] == $vehicle['name']){
                                $array[16] = $vehicle['class'];
                                $array[18] = $vehicle['number_of_passengers'];
                                $array['vehicle_class_id'] = $vehicle['id'];
                            }
                        }
                    }
                    
                    if($i == 19){
                        
                        foreach($modelEnterprise as $enterprise){

                            if(strstr($array[$i], $enterprise['name'])){
                                $array[22] = $enterprise['NIT'];
                                $array['enterprise_id'] = $enterprise['id'];
                            }
                        }
                    }
                }
            }
        }

        foreach($collection as $matrix){
            
            foreach($matrix as $array){
                
                Dispatchs::create([
                    'invoice_number' => $array[0],
                    'name_route' => $array[1],
                    'date' => $array[2],
                    'hour' => $array[3],
                    'minute' => $array[4],
                    'usage_rate' => $array[14],
                    'plate' => $array[15],
                    'authorized_dispatch' => $array[9],
                    'type_of_dispatch' => $array[10],
                    'vehicle_class_id' => $array['vehicle_class_id'],
                    'enterprise_id' => $array['enterprise_id'],
                    'origin_municipality_id' => $array['origin_municipality_id'],
                    'destination_municipality_id' => $array['destination_municipality_id']
                ]);

            }

        }

        $confirm = true;

        return redirect()->route('home', ['confirm' => $confirm]);
    }

    public function export(){

        return Excel::download(new DispatchsExport, 'generate.xlsx');
    }

    // public function import(Request $request){
        
    //     $request->file('dispatch')->storeAs('public', $request->file('dispatch')->getClientOriginalName());

       
    //     $collection = Excel::toCollection(new ImportsDispatchController, 'public/'.$request->file('dispatch')->getClientOriginalName());

    //     $data = [];

    //     $modelMunicipality = DB::table('municipalities')

    //                 ->join('departments', 'departments.id_department', '=', 'municipalities.department_id')

    //                 ->select('municipalities.id_municipality as id', 'municipalities.name as municipality', 'departments.code as department_code', 'municipalities.code as municipality_code', 'municipalities.main')
                    
    //                 ->get();

    //     $modelVehicleClass = VehicleClass::select('id_vehicle_class as id', 'name', 'class', 'number_of_passengers')->get();
        
    //     $modelEnterprise = Enterprises::select('id_enterprise as id', 'NIT', 'name')->get();
        
    //     foreach($collection as $matrix){

    //         foreach($matrix as $array){

    //             $rate = 0;
    //             $alcoholimetry = 0;

    //             for($i = 0; $i < count($array); $i ++){

    //                 if($i == 1){

    //                     $main = [];

    //                     foreach($modelMunicipality as $content){

    //                         if(strstr($array[$i], "$content->municipality -") && !strstr($array[$i], "- $content->municipality -")){
                                    
    //                             $main['origin'] = $content->main;
    //                             $array[5] = $content->department_code;
    //                             $array[6] = $content->municipality_code;
    //                             $array['origin_municipality_id'] = $content->id; 
    //                         }

    //                         if(strstr($array[$i], "- $content->municipality") && !strstr($array[$i], "- $content->municipality -")){
                                
    //                             $main['destination'] = $content->main;
    //                             $array[7] = $content->department_code;
    //                             $array[8] = $content->municipality_code;
    //                             $array['destination_municipality_id'] = $content->id;
    //                         }

    //                         if(strstr($array[$i], "- $content->municipality -")){
    //                             $main['transition'] = $content->main;
    //                         }

    //                         if(isset($main['origin']) && !isset($main['transition']) && isset($main['destination'])){

    //                             $array[10] = 1;

    //                             if($main['origin'] && $main['destination']){
    //                                 $array[9] = 2;
    //                             }elseif(!$main['destination']){
    //                                 $array[9] = 1;
    //                             }

    //                         }elseif(isset($main['origin']) && isset($main['transition']) && isset($main['destination'])){

    //                             $array[10] = 2;

    //                             if($main['origin'] && $main['transition'] && $main['destination']){
    //                                 $array[9] = 3;
    //                             }elseif(!$main['origin'] && $main['transition'] && $main['destination']){
    //                                 $array[9] = 4;
    //                             }elseif($main['origin'] && $main['transition'] && !$main['destination']){
    //                                 $array[9] = 5;
    //                             }

    //                         }

    //                     }    
        
    //                 }

    //                 if($i == 11){
    //                     $rate = $array[$i];
    //                 }elseif($i == 13){
    //                     $alcoholimetry = $array[$i];
    //                 }

    //                 $array[14] = $rate + $alcoholimetry;

    //                 if($i == 17){

    //                     foreach($modelVehicleClass as $vehicle){

    //                         if(strstr($array[$i], $vehicle['name'])){
    //                             $array[16] = $vehicle['class'];
    //                             $array[18] = $vehicle['number_of_passengers'];
    //                             $array['vehicle_class_id'] = $vehicle['id'];
    //                         }
    //                     }
    //                 }
                    
    //                 if($i == 19){
                        
    //                     foreach($modelEnterprise as $enterprise){

    //                         if(strstr($array[$i], $enterprise['name'])){
    //                             $array[22] = $enterprise['NIT'];
    //                             $array['enterprise_id'] = $enterprise['id'];
    //                         }
    //                     }
    //                 }

    //                 $data[] = $array;
    //             }
    //         }
    //     }

    //     return $data;

    //     foreach($data as $create){
            
    //         Dispatchs::create([
    //             'invoice_number' => $create[0],
    //             'name_route' => $create[1],
    //             'date' => $create[2],
    //             'hour' => $create[3],
    //             'minute' => $create[4],
    //             'usage_rate' => $create[14],
    //             'plate' => $create[15],
    //             'vehicle_class_id' => $create['vehicle_class_id'],
    //             'enterprise_id' => $create['enterprise_id'],
    //             'origin_municipality_id' => $create['origin_municipality_id'],
    //             'destination_municipality_id' => $create['destination_municipality_id']
    //         ]);

    //     }
    //     return Excel::download($collection, $request->file('dispatch')->getClientOriginalName());
    // }
}
