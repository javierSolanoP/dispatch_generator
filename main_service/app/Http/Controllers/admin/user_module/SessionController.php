<?php

namespace App\Http\Controllers\admin\user_module;

use App\Http\Controllers\Controller;
use App\Models\Session;

class SessionController extends Controller
{

    public function index()
    {
        // Realizamos la consulta a la DB: 
        $model = Session::get();

        // Si existen registros, retornamos la respuesta: 
        if(count($model) != 0){

            // Retornamos la respuesta: 
            return ['query' => true, 'sessions' => $model];

        }else{
            // Retornamos el error: 
            return ['query' => false, 'error' => 'No existen sesiones registradas en el sistema.'];
        }
    }

    public function show($status)
    {
        // Realizamos la consulta a la DB: 
        $model = Session::where('type_of_session', $status);

        // Validamos que exista el registro en la entidad: 
        $validateSession = $model->first();

        // Si existen registros, retornamos la respuesta: 
        if($validateSession){

            // Retornamos la respuesta: 
            return ['query' => true, 'session' => $validateSession];

        }else{
            // Retornamos el error: 
            return ['query' => false, 'error' => 'No existe esa sesion en el sistema.'];
        }
    }

}
